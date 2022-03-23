<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
    <loc>https://thaomocuytin.com</loc>
    <priority>1</priority>
    <lastmod><?php echo Date('Y-m-d');?></lastmod>
    <changefreq>daily</changefreq>
</url>
@foreach ($products as $product)
<url><loc>https://thaomocuytin.com{{genProductLink($product['category_slug'], $product['slug'])}}</loc><priority>0.8</priority><lastmod>{{Date('Y-m-d', strtotime($product['updated_at']))}}</lastmod><changefreq>daily</changefreq></url>
@endforeach
</urlset>
