<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
@foreach ($cates as $cate)
<url><loc>https://thaomocuytin.com{{genCateLink($cate['slug'])}}</loc><priority>0.8</priority><lastmod>{{Date('Y-m-d', strtotime($cate['updated_at']))}}</lastmod><changefreq>daily</changefreq></url>
@endforeach
</urlset>
