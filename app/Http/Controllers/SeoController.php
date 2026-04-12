<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analysis;
use App\Helpers\SeoHelper;
use Barryvdh\DomPDF\Facade\Pdf;

class SeoController extends Controller
{
    public function analyze(Request $request)
    {
        $user = auth()->user();

        $count = Analysis::where('user_id', $user->id)
            ->wheredate('created_at', today())->count();

        if ($count >= $user->limit) {
            return back()->with('error', 'Limit harian tercapai (' . $user->limit . 'x)');
        }

        $request->validate([
            'url' => 'required|url'
        ]);

        $url = $request->url;
        $keyword = $request->keyword;

        $html = @file_get_contents($url);

        if (!$html) {
            return back()->with('error', 'Website tidak bisa diakses');
        }

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($html);

        // TITLE
        $titleNode = $dom->getElementsByTagName("title")->item(0);
        $title = $titleNode ? $titleNode->nodeValue : '';

        // META & OG
        $desc = '';
        $og = false;

        foreach ($dom->getElementsByTagName("meta") as $meta) {
            if ($meta->getAttribute("name") === "description") {
                $desc = $meta->getAttribute("content");
            }
            if ($meta->getAttribute("property") === "og:title") {
                $og = true;
            }
        }

        // HEADINGS
        $h1 = $dom->getElementsByTagName("h1")->length;
        $h2 = $dom->getElementsByTagName("h2")->length;

        // IMAGES
        $img_no_alt = 0;
        foreach ($dom->getElementsByTagName("img") as $img) {
            if (!$img->hasAttribute("alt") || $img->getAttribute("alt") === '') {
                $img_no_alt++;
            }
        }

        // LINKS
        $internal = 0;
        $external = 0;
        $host = parse_url($url, PHP_URL_HOST);

        foreach ($dom->getElementsByTagName("a") as $link) {
            $href = $link->getAttribute("href");

            if (str_contains($href, $host)) {
                $internal++;
            } elseif (str_starts_with($href, 'http')) {
                $external++;
            }
        }

        // CANONICAL
        $canonical = false;
        foreach ($dom->getElementsByTagName("link") as $link) {
            if ($link->getAttribute("rel") === "canonical") {
                $canonical = true;
            }
        }

        // TECHNICAL
        $https = SeoHelper::checkHttps($url);
        $sitemap = SeoHelper::checkSitemap($url);
        $robots = SeoHelper::checkRobots($url);

        // KEYWORD
        $density = SeoHelper::keywordDensity($html, $keyword);

        // SCORE
        $score = 0;
        if ($title && strlen($title) <= 60) $score += 15;
        if ($desc && strlen($desc) <= 160) $score += 15;
        if ($h1 === 1) $score += 10;
        if ($img_no_alt === 0) $score += 10;
        if ($https) $score += 10;
        if ($sitemap) $score += 10;
        if ($robots) $score += 10;
        if ($canonical) $score += 10;
        if ($og) $score += 5;
        if ($density > 0.5 && $density < 3) $score += 5;

        $analysis = Analysis::create([
            'user_id' => auth()->id(),
            'url' => $url,
            'title' => $title,
            'description' => $desc,
            'h1' => $h1,
            'h2' => $h2,
            'img_no_alt' => $img_no_alt,
            'internal_links' => $internal,
            'external_links' => $external,
            'https' => $https,
            'sitemap' => $sitemap,
            'robots' => $robots,
            'canonical' => $canonical,
            'og_tags' => $og,
            'keyword_density' => $density,
            'score' => $score,
        ]);

        $recommendations = $this->generateRecommendations([
            'title' => $title,
            'description' => $desc,
            'h1' => $h1,
            'img_no_alt' => $img_no_alt,
            'https' => $https,
            'sitemap' => $sitemap,
            'robots' => $robots,
            'canonical' => $canonical,
            'og_tags' => $og,
            'keyword_density' => $density
        ]);

        return view('result', compact('analysis', 'recommendations'));
    }

    public function history(Request $request)
    {
        $search = $request->search;

        $analyses = Analysis::where('user_id', auth()->id())->latest()->paginate(10);

        $chartData = Analysis::latest()->take(10)->get()->reverse();

        return view('history', compact('analyses', 'search', 'chartData'));
    }

    public function delete($id)
    {
        Analysis::where('id', $id)->where('user_id', auth()->id())->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    private function generateRecommendations($data)
    {
        $rec = [];
    
        // TITLE
        if (!$data['title']) {
            $rec[] = ['status' => 'bad', 'text' => 'Title tidak ditemukan'];
        } elseif (strlen($data['title']) > 60) {
            $rec[] = ['status' => 'warning', 'text' => 'Title terlalu panjang (maks 60 karakter)'];
        } else {
            $rec[] = ['status' => 'good', 'text' => 'Title sudah optimal'];
        }
    
        // META DESCRIPTION
        if (!$data['description']) {
            $rec[] = ['status' => 'bad', 'text' => 'Meta description tidak ditemukan'];
        } elseif (strlen($data['description']) > 160) {
            $rec[] = ['status' => 'warning', 'text' => 'Meta description terlalu panjang'];
        } else {
            $rec[] = ['status' => 'good', 'text' => 'Meta description sudah optimal'];
        }
    
        // H1
        if ($data['h1'] == 0) {
            $rec[] = ['status' => 'bad', 'text' => 'Tidak ada H1'];
        } elseif ($data['h1'] > 1) {
            $rec[] = ['status' => 'warning', 'text' => 'Terlalu banyak H1'];
        } else {
            $rec[] = ['status' => 'good', 'text' => 'H1 sudah baik'];
        }
    
        // IMAGE ALT
        if ($data['img_no_alt'] > 0) {
            $rec[] = ['status' => 'warning', 'text' => 'Ada gambar tanpa ALT'];
        } else {
            $rec[] = ['status' => 'good', 'text' => 'Semua gambar memiliki ALT'];
        }
    
        // HTTPS
        if (!$data['https']) {
            $rec[] = ['status' => 'bad', 'text' => 'Website belum menggunakan HTTPS'];
        } else {
            $rec[] = ['status' => 'good', 'text' => 'HTTPS aktif'];
        }
    
        // SITEMAP
        if (!$data['sitemap']) {
            $rec[] = ['status' => 'warning', 'text' => 'Sitemap tidak ditemukan'];
        } else {
            $rec[] = ['status' => 'good', 'text' => 'Sitemap tersedia'];
        }
    
        // ROBOTS
        if (!$data['robots']) {
            $rec[] = ['status' => 'warning', 'text' => 'Robots.txt tidak ditemukan'];
        } else {
            $rec[] = ['status' => 'good', 'text' => 'Robots.txt tersedia'];
        }
    
        // CANONICAL
        if (!$data['canonical']) {
            $rec[] = ['status' => 'warning', 'text' => 'Canonical tag tidak ditemukan'];
        } else {
            $rec[] = ['status' => 'good', 'text' => 'Canonical sudah ada'];
        }
    
        // OPEN GRAPH
        if (!$data['og_tags']) {
            $rec[] = ['status' => 'warning', 'text' => 'Open Graph tidak ditemukan'];
        } else {
            $rec[] = ['status' => 'good', 'text' => 'Open Graph tersedia'];
        }
    
        // KEYWORD DENSITY
        if ($data['keyword_density'] == 0) {
            $rec[] = ['status' => 'warning', 'text' => 'Keyword tidak ditemukan di halaman'];
        } elseif ($data['keyword_density'] > 3) {
            $rec[] = ['status' => 'bad', 'text' => 'Keyword terlalu banyak (keyword stuffing)'];
        } else {
            $rec[] = ['status' => 'good', 'text' => 'Keyword density optimal'];
        }
    
        return $rec;
    }

    public function exportPdf($id)
    {
        $analysis = \App\Models\Analysis::findOrFail($id);
    
        // generate ulang recommendation
        $recommendations = $this->generateRecommendations([
            'title' => $analysis->title,
            'description' => $analysis->description,
            'h1' => $analysis->h1,
            'img_no_alt' => $analysis->img_no_alt,
            'https' => $analysis->https,
            'sitemap' => $analysis->sitemap,
            'robots' => $analysis->robots,
            'canonical' => $analysis->canonical,
            'og_tags' => $analysis->og_tags,
            'keyword_density' => $analysis->keyword_density
        ]);
    
        $pdf = Pdf::loadView('pdf.report', compact('analysis', 'recommendations'));
    
        return $pdf->download('seo-report.pdf');
    }

    public function show($id)
    {
        $analysis = Analysis::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $recommendations = $this->generateRecommendations([
            'title' => $title,
            'description' => $desc,
            'h1' => $h1,
            'img_no_alt' => $img_no_alt,
            'https' => $https,
            'sitemap' => $sitemap,
            'robots' => $robots,
            'canonical' => $canonical,
            'og_tags' => $og,
            'keyword_density' => $density
        ]);

        return view('result', compact('analysis', 'recommendations'));
    }
}