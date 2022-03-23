<?php

use Intervention\Image\ImageManagerStatic as Image;
use Google\Cloud\Storage\StorageClient;
use phpDocumentor\Reflection\Types\Null_;
use App\Models\Product;
use App\Constant;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use PharIo\Manifest\Url as ManifestUrl;

function genProductLink($slugCategory, $slugNews)
{
    if ($slugCategory) {
        return "/$slugCategory/$slugNews";
    }

    return "/tin-tuc/$slugNews";
}

function genAuthorLink($slug)
{
    return "/author/$slug";
}

function genTagLink($slug)
{
    return "/tag/$slug";
}

function genCateLink($slug, $parentSlug = "")
{
    if ($parentSlug) {
        return "/$parentSlug/$slug";
    }

    return "/$slug";
}

function genProviderLink($slug)
{
    return "/thuong-hieu/$slug";
}

function getCanonical()
{
    $url = Request::url();;

    # It's search page
    if (strpos($url, 'tim-kiem')) {
        return Constant::DOMAIN; # Home page
    }
    return $url;
}
/**
 * Sub string by character length
 */
function _substr($str, $length = 70, $minword = 3)
{
    $sub = '';
    $len = 0;
    foreach (explode(' ', $str) as $word) {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        if (strlen($word) > $minword && strlen($sub) >= $length) {
            break;
        }
    }
    return $sub . (($len < strlen($str)) ? '...' : '');
}

function uploadImageToGCP($file)
{
    $fileName = $file->getClientOriginalName();

    $storage = new StorageClient([
        'keyFilePath' => public_path() . '/phukienone-b79a0e63c8a6.json'
    ]);
    $bucket = $storage->bucket('thaomocuytin');
    foreach ($bucket->objects() as $object) {
        if ($fileName == $object->name()) { # check exist name on GCP
            return '';
        }
    }
    $fileData = explode('.', $fileName);
    $fileName = $fileData[0];
    $fileExtension = $fileData[1];

    $image_resize = Image::make($file->getRealPath());

    $fileName = $fileName . '-' . time() . '.' . $fileExtension;

    # original
    $pathOriginal = public_path("/images/images/original/$fileName");
    $image_resize->save($pathOriginal);
    # width is 600
    $image_resize->resize(600, null, function ($constraint) {
        $constraint->aspectRatio();
    });
    $path600 = public_path("/images/images/600/$fileName");
    $image_resize->save($path600);
    # witdth is 400
    $image_resize->resize(400, null, function ($constraint) {
        $constraint->aspectRatio();
    });
    $path400 = public_path("/images/images/400/$fileName");
    $image_resize->save($path400);
    # witdth is 220
    $image_resize->resize(220, null, function ($constraint) {
        $constraint->aspectRatio();
    });
    $path200 = public_path("/images/images/200/$fileName");
    $image_resize->save($path200);
    # witdth is 100
    $image_resize->resize(100, null, function ($constraint) {
        $constraint->aspectRatio();
    });
    $path100 = public_path("/images/images/100/$fileName");
    $image_resize->save($path100);

    $result = $bucket->upload(fopen($pathOriginal, 'r'), ['name' => "images/images/original/$fileName", 'metadata' => [
        'cacheControl' => 'Cache-Control: private, max-age=31536000'
    ]]);
    $result = $bucket->upload(fopen($path600, 'r'), ['name' => "images/images/600/$fileName", 'metadata' => [
        'cacheControl' => 'Cache-Control: private, max-age=31536000'
    ]]);
    $result = $bucket->upload(fopen($path400, 'r'), ['name' => "images/images/400/$fileName", 'metadata' => [
        'cacheControl' => 'Cache-Control: private, max-age=31536000'
    ]]);
    $result = $bucket->upload(fopen($path200, 'r'), ['name' => "images/images/200/$fileName", 'metadata' => [
        'cacheControl' => 'Cache-Control: private, max-age=31536000'
    ]]);
    $result = $bucket->upload(fopen($path100, 'r'), ['name' => "images/images/100/$fileName", 'metadata' => [
        'cacheControl' => 'Cache-Control: private, max-age=31536000'
    ]]);

    unlink($pathOriginal);
    unlink($path600);
    unlink($path400);
    unlink($path200);
    unlink($path100);

    return $fileName;
}

/**
 * Upload image to own server
 */
function uploadImage($file)
{
    $fileName = $file->getClientOriginalName();

    $fileData = explode('.', $fileName);
    $fileName = $fileData[0];
    $fileExtension = $fileData[1];

    $image_resize = Image::make($file->getRealPath());

    $fileName = $fileName . '-' . time() . '.' . $fileExtension;

    # original
    $pathOriginal = public_path("/images/images/original/$fileName");
    $image_resize->save($pathOriginal);
    # width is 600
    $image_resize->resize(600, null, function ($constraint) {
        $constraint->aspectRatio();
    });
    $path600 = public_path("/images/images/600/$fileName");
    $image_resize->save($path600);
    # witdth is 400
    $image_resize->resize(400, null, function ($constraint) {
        $constraint->aspectRatio();
    });
    $path400 = public_path("/images/images/400/$fileName");
    $image_resize->save($path400);
    # witdth is 220
    $image_resize->resize(220, null, function ($constraint) {
        $constraint->aspectRatio();
    });
    $path200 = public_path("/images/images/200/$fileName");
    $image_resize->save($path200);
    # witdth is 100
    $image_resize->resize(100, null, function ($constraint) {
        $constraint->aspectRatio();
    });
    $path100 = public_path("/images/images/100/$fileName");
    $image_resize->save($path100);

    return $fileName;
}

/**
 * Gen image from GCP
 */
function genImage($name, $size = '')
{
    $domain = env('DOMAIN', 'https://thaomocuytin.com');
    if (strpos($name, '/images/images/') !== false) {
        return $domain . $name;
    }
    if ($size) {
        return $domain . "/images/images/$size/$name";
    } else {
        return $domain . "/images/images/original/$name";
    }
}

/**
 * Gen menu at news detail
 */
function genCatalogue($content)
{
    $regex = "/<h2.*?>(.*)<\/h2>/";
    preg_match_all($regex, $content, $titles);

    $result = '';
    foreach ($titles[1] as $title) {
        $title = strip_tags($title);
        $result .= "<li><a href='#'>$title</a></li>";
    }
    return $result;
}


function formatPrice($price)
{
    return number_format($price, 0, '.', ',');
}

function getLastPrice($price, $discountType, $discount)
{
    if (!$discountType || !$discount) {
        return sprintf('%s ₫', number_format($price, 0, ',', '.'));
    }

    if ($discountType == Product::DISCOUNT_TYPE_MONEY) {
        $lastPrice = $discount;
    } else {
        $lastPrice = $price - $price * $discount / 100;
    }

    return sprintf('%s ₫', number_format($lastPrice, 0, ',', '.'));
}

function getDiscount($discountType, $discount)
{
    if (!$discountType || !$discount) {
        return 0;
    }

    if ($discountType == Product::DISCOUNT_TYPE_MONEY) {
        return sprintf('%s ₫', number_format($discount, 0, ',', '.'));
    } else {
        return $discount . ' %';
    }
}

function truncate($string, $length = 40, $dots = "...")
{
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}

function getColorName($colorIndex)
{
    if ($colorIndex == 1) {
        return 'Trắng';
    } elseif ($colorIndex == 2) {
        return 'Đen';
    } elseif ($colorIndex == 3) {
        return 'Đỏ';
    } else {
        return 'Xanh';
    }
}

function removeAccents($str)
{
    if (!$str) return false;
    $utf8 = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'd' => 'đ|Đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach ($utf8 as $ascii => $uni) $str = preg_replace("/($uni)/i", $ascii, $str);
    return $str;
}


function genRating($rating)
{
    if (!$rating) {
        return 'Chưa có đánh giá';
    }
    $ratingInt = (int) $rating;
    $str = "";

    for ($i = 0; $i < $ratingInt; $i++) {
        $str .= '<i class="icon-star"></i>';
    }
    $detal = $rating - $ratingInt;
    $numberNoStar = 5 - $ratingInt;
    if ($detal) {
        $str .= '<i class="icon-star-half"></i>';
        $numberNoStar -= 1;
    }
    for ($i = 0; $i < $numberNoStar; $i++) {
        $str .= '<i class="icon-star-empty"></i>';
    }
    return $str;
}


function coverageRatingScore($ratings)
{
    $totalRating = count($ratings);
    if (!$totalRating) {
        return 0;
    }

    $score = 0;
    foreach ($ratings as $rating) {
        $score += $rating['rating'];
    }

    return number_format($score / $totalRating, 1);
}


function maxRatingScore($ratings)
{
    if (!count($ratings)) {
        return 0;
    }

    $maxRating = 0;
    foreach ($ratings as $rating) {
        if ($rating['rating'] > $maxRating) {
            $maxRating = $rating['rating'];
        }
    }

    return $maxRating;
}

/**
 * Process producte category seo title
 */
function processCategorySeoTile($seoTitle, $numberProduct)
{
    return str_replace('$1', $numberProduct, $seoTitle);
}


function genFromLink($from)
{
    return "/xuat-xu/$from";
}

/**
 * Get unique nation from provides
 */
function getNationFromProviders($providers)
{
    if (!$providers) {
        return null;
    }

    $nations = [];
    foreach ($providers as $provider) {
        if (!array_key_exists($provider->from_slug, $nations)) {
            $nations[$provider->from_slug] = $provider->from;
        }
    }

    return $nations;
}


function genLinkWithParam($key, $param)
{
    $url = URL::current();
    $urlQuery = parse_url(Request::fullUrl(), PHP_URL_QUERY);
    if (!$urlQuery) {
        return $url . "?$key=$param";
    }

    if (strpos($urlQuery, $key) !== false) {
        $patten = "/$key\=([A-z \- 0-9])+/";
        $urlQuery = preg_replace($patten, "$key=$param", $urlQuery);
    } else {
        $urlQuery .= "&$key=$param";
    }

    return $url . '?' . $urlQuery;
}


function genSKU($id)
{
    return sprintf('P%06d', $id);
}


/**
 * Process image content
 */
function processImageContent($content)
{
    $pattern = '/\<img alt\=\"(.*?)\" src\=\"((?!.*loader\.svg).*?)\"/i';
    $replacement = '<img alt="$1" data-src="$2" src="https://thaomocuytin.com/images/images/loader.svg" ';
    return preg_replace($pattern, $replacement, $content);
}

function getDescription($description, $length = 300)
{
    $description = strip_tags($description);
    $description = html_entity_decode($description, ENT_QUOTES, "utf-8");
    return strtok(wordwrap($description, $length, "...\n"), "\n");
}

function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}



function RandomCustomerName()
{
    $existName = ["Tran Quoc Thanh", "Đức Giang", "Thoa Phan", "Thị Thắm", "PhuongLinh Nguyen", "Lê Thị Hồng Thắm", "Dương Đình Tú", "VUONG KHANG", "Trần Văn Kiên", "Ngô Trí Luật", "Lê Quang Minh", "TRAN PHUONG TRUNG", "Nguyễn Nguyệt", "Nguyễn hoa", "Nguyễn Hương", "Nguyễn Thanh Hằng", "Le Hanh", "Khánh Linh", "Thu", "Thanh Quang", "Nhật Bún", "Park Young Hyun", "Tuấn", "Thủy", "Thông", "Kiều Trang", "Tú", "Minh", "Duy Anh", "Phương", "Vũ Tuấn Khoa", "Nhàn", "ledat25", "Tony Bernice", "Tào Quang Huy", "Mơ Hồ", "hung", "Thành", "Ngân Nhi Trần", "vương ngoc cường", "Nhím con", "Hương Giang", "trinh", "Hoàng Nô", "Tùng Trần", "Hồ Minh Toàn", "Tùng", "Ha Quynh Huong", "Đỗ Ngân Trang", "Vương Thị Lan Anh", "Vương Thị Lan Anh", "Dương", "Trịnh Thuỳ Dương", "Phuong Anh", "trần thanh hương", "Triệu Thu Hằng", "thaovy", "mạnh", "Văn Tới Bùi", "dương hải tùng", "Dân Nguyễn", "nguyễn hữu nam", "Thế Minh", "Hoà Chanel", "Nguyễn Văn Thiêng", "Thao Bùi", "nguyen trung hoa", "Phong Lê", "Hà Thị Thuý Hằng", "Thường Nguyễn", "lê hoang long", "Dương Nga", "Lương Thị Ngọc Anh", "Phạm Yến", "Hoàng Thị Liên", "Linh", "Phạm Thống", "Nguyễn Thị Đoài", "Nguyễn Châu", "tranhoa", "hoàng mỹ duyên", "Nguyễn Thùy Linh", "Nguyễn Duy Bính", "nguyễn quỳnh anh", "nguyễn quỳnh anh", "Vũ Thế Duy", "Trần Phương", "Lan Linh", "phạm thanh tuấn", "Mai", "Hoàng Anh Đức", "Phúc", "Mai", "Nguyễn Thu Huyền", "Nguyễn Thị Hoàng Anh", "Linh", "đỗ thị phuong thảo", "Lê Thị Diệu Thúy", "Hoàng Minh Nga", "Phương Dung", "Nguyễn Thuý Nga", "Nguyễn Ngọc Thảo", "Ngọc Huy", "trần minh anh", "Nghiêm Thị Nhài", "Đỗ Thị Thư", "nguyễn Hồng Liên", "Quỳnh", "Nông Thị Trang", "Trang", "Tuyên", "Nông Thị Hoài Trang", "Nguyễn Thị Thuỷ", "Đăng", "phạm thái hòa", "Minh Khánh", "Minh", "Thắng", "Nguyễn Huyền Trang", "Vũ Thị Hạnh", "Trần Duy", "trần duy", "Triệu Việt Dũng", "Nông Thành", "Le Huyen", "hoàng đăng khoa", "hoàng đăng khoa", "ngôhiểu", "ngô Minh Hiếu", "minh", "Thuy Linh Duong", "Quý Hiển", "lương trung anh", "Nguyễn Trung Kiên", "Tuan", "Bùi Quyền Linh", "Đỗ Văn Lương", "Xuân Tài", "phạm diệu linh", "lê văn chính", "Nguyễn Hồng Thái", "Đức Anh", "Rigil Kentarus", "Nguyễn Hải Đăng", "Đặng duy Việt", "hiếu", "Ngô Thị Thùy Linh", "Diễm", "Phạm Khắc Đạt", "Tạ Minh Đức", "Nguyễn Đức Dương", "phạm trưởng", "Nguyễn Quyết Thắng", "Thế", "Thảo", "Nhung", "Hoàng Thị Kiều Anh", "vũ thị oanh", "Sơn Nguyễn", "DoanLe", "Đức Thịnh", "Ngô Hà Trang", "Ngô Hà Trang", "trương thuý quỳnh", "Phạm Minh Phương", "Như Quỳnh", "Anh Long", "Trường", "Bảo Dung", "vuha", "Thúy An", "Nguyễn Hưng Bắc", "Nguyễn Thị Nhàn", "Hằng", "Đạt", "An Nhiên", "hoàng long", "Yen Nana", "Đỗ Trung Hiếu", "Đỗ Ngọc Yến", "hoang lan", "Bùi thị thu trang", "Huệ", "trấn thị ngọc hằng", "Hoàng Thuỳ Ngân", "Trương Thao", "Tô Trà Mi", "Tình", "Trịnh Hồng Anh", "nguyen thanh huyen", "Lành Thủy Ngân", "Hạc Huyền My", "Nguyễn Thị Tân", "Lê Anh", "Thanh Xuân", "Lê Thị Hòa", "Nguyễn Tiến Đạt", "Minh Nguyễn", "Huỳnh Tấn Hải", "ngo thu huong", "ngo thu huong", "Đinh Thuý Hà", "Hoàng Thị Vân Anh", "Nguyễn Thị Hải", "minhtuan", "Lê Du", "Dương Thị Thu", "mạc thanh", "mạc thanh", "Hà", "Hà Lan Anh", "phạm gia linh", "Huyền Huyền", "Phuơng", "Nguyễn Hoài", "Trang", "Trang", "lê thị thu hằng", "Hiếu", "Lượng", "trịnh minh hiếu", "lonh", "Nguyên Duy", "Tuấn", "Phan Trà My", "bùi thanh tùng", "Đăng Đôn", "Trịnh Thị Hồng Quang", "phan xuân lộc", "Ánh", "Hoang Nguyen", "nguyễn văn tuyên", "My", "nong huu bach", "tungchaumet", "Mạnh", "Ất", "tài", "Lê Anh", "đức anh", "cao xuan huy", "cao xuan huy", "Vũ Minh Quân", "nguyễn văn cường", "nguyễn văn truyền", "Nguyễn Thị Ánh Vinh", "nguyễn hoàng huy", "minh nguyen", "nguyễn đức duy", "Bùi Xuân Thùy", "Anh Nguyen", "Đoài Nguyễn", "Hoàng Thị Yến", "Dương Linh", "trần thị tuyết mai", "Thao Huong Nguyen Le", "Hồ Tuấn", "Phan Tú", "Trần thị Hiền", "bùi thanh hải", "Lê Việt Nhật", "Đình Quý", "Thế Việt Cb", "phạm anh tuấn", "Liên Nguyễn", "Tài", "Tuấn", "Bố Đời", "đặng tiến dũng", "Lê Đức Trung", "Lê Đức Trung", "Le Tuan", "Nam Thắng", "nguyen dong", "hồ văn hưng", "Nguyễn Văn hùng", "vu van cong", "Thanh Tùng", "le dinh sang", "Xuân Bình", "vu huu ba", "duyan", "Hoa Hồng Bên Lề", "Nguyễn Phương Nhật Anh", "Hanh Bich Đăng", "Hồng Trần", "Chu Em", "Vũ Thị Nết", "Giang Công Anh", "Duy Cuong Nguyen", "thao", "Duyen Tran", "Trọng", "nguyễn mạnh hải", "Mạnh Hải", "Hoàng Hương Diễm", "Phương Trần Con", "Ngô Huyền", "đặng Vân Anh", "Hiển Heo", "Tuấn", "Hùng", "Trung Đầu Bạc", "Trần Quang Lâm", "Hoàng Anh", "Nguyen Minh Quan", "Hà", "Phương Anh", "Ngọc Toàn", "Hoàng Nhi", "Trịnh Hoài Thu", "trịnh hoài thu", "Lan Anh", "Phương Anh", "Đoàn Mai Chi", "Hồng Vân", "Đoàn Đức Tùng", "Bảo", "Hoàng Yến", "Phạm Linh", "linh trịnh", "Linh Trịnh", "lai van luyen", "Khuê", "Nguyen Thu Trang", "Le Thi Bich Diep", "Kậu Út Họ Ngô", "Phạm Linh", "Ngô Khánh Ly", "Nguyễn Đức Thịnh", "Nguyễn Hà", "Hoàng Ngân Hà", "Nguyen Thi Huong", "trung ngọc mai", "linh vyy", "Lan Anh", "Kieen", "lê mạnh cường", "Hùng", "Bánh", "nguyễn ánh tuyết", "nguyễn đinh tuấn", "nguyễn văn cường", "tran xuan thanh", "lê hoàng", "Ngọc Béo", "lương hoàng phúc", "Khánh Trương", "Trần Lan", "Vũ Gia Khánh", "Duyhoan", "Minh Nguyệt", "đạt", "hoang minh hai", "Thai quang nam", "hoang minh hai", "thái an", "Trung Đức", "Lương Tuấn Tùng", "Nguyễn Thị Diệu My", "Thắm", "Hoàng Anh", "Lê Tiến Đạt", "Hoàng Linh", "Kim Thoa Pham", "Trâm", "Thanh", "Lê Minh Đức", "Nguyễn Vũ Thư Phương", "Nguyễn Vũ Thư Phương", "Nguyễn Quang", "Ngọc", "Giang", "Quyền", "Hiếu Cồ", "Hiền", "phan đức chính", "nguyễn tá hiếu", "Tá Hiếu", "Nguyễn Đức Trung. Bob", "Nguyễn Thủy", "Anh", "Sơn", "Nguyen thuy trang", "bùi trường giang", "Nguyễn Beead", "Bình", "Xuân Quang", "Hoàng Trung Kiên", "Thảo", "Phan Viết Phương", "Dũng", "Ánh", "Vân", "Luyến", "Việt", "Huyền", "Ngân", "Dương", "Pham Huy", "Tuấn", "Nguyễn Thị Hoài Thu", "Nguyễn Linh Phương", "nguyễn bá buấn", "Cao Anh Quân", "Vũ Uyên", "Nguyễn Vân", "Nguyễn Thu Hà", "Vũ Uyên", "thái thị trang nhung", "nam", "Dương Hương", "Quang", "leanh", "Tuấn", "Trần Quang Mỹ", "Lê Anh", "Phượng", "nguyễn thuỳ linh", "nguyễn thuỳ linh", "Đặng Khánh Huyền", "nguyễn quốc", "trần thị khánh linh", "Thu Hà", "Vũ Văn Cương", "Phạm Hữu Hải", "Tuyến", "Thang Be Kho", "Thủy", "Lê Thị Đức Ngân", "Đỗ văn quang", "hoàng thu trang", "Văn Duyệt TP", "Nguyễn Thị Thanh Tâm", "Nguyễn Hoàng Hải", "phuonganh", "ngọc", "Bùi Đình Thịnh", "Trần Thu Thuỷ", "Lê Tuấn Hưng", "Quyên", "tran minh hien", "Nguyễn Huyền Thương", "Doan Thi Thuy Dung", "Ngô Phương Anh", "Nguyễn Thị Thu Hương", "Gia Quyết", "Thu Uyên", "quan", "trương minh ngọc", "Siêu nhân đen", "Minh Quân", "phạm thị thu hà", "khánh hoàng", "Tran Thi Phuong", "Ngô Ngọc Thắng", "Nguyễn Thuý Vân", "trần thị hồng", "Đàm Hải Thành", "Lê Huyền", "Ánh", "Jzj Pham", "Trọng Hiếu", "Thuận", "Đỗ Long", "Sơn", "Đạt Nguyễn", "pham minh phong", "tuyên", "nguyen van dai", "Nam", "Nam", "Xoong Nguyen", "Tuấn Tú", "Vũ Vân", "Trần Văn Tuyền", "đoàn văn thịnh", "đoàn văn thịnh", "vũ thị phương anh", "Trung Nguyen", "Trung", "Đào Thị Vân", "Đào Thị Vân", "hướng", "Bình An", "tunganh", "Nguyen Thi Huyen", "tunganh", "Em Là Để Yêu", "nguyễn hữu thái", "nguyễn khánh linh", "Hưng Gia Hoàng", "Thiên Trang", "Quynh Thu", "Bui Thi Ngoc Ha", "Trần Hiếu", "ttt", "Dũng", "Nguyễn Hoàng Tuấn", "Lê Phương", "Bún Hương Giang", "Huỳnh Hào", "Hồng Long", "Tuấn Anh", "Nguyễn Xuân Tiệp", "Hằng Nga", "vũ phương thảo", "Hoà", "Hoà", "Thanh Thủy", "Tam Ngo", "Cao", "trần anh tuấn", "Thủy", "Thuý", "Bảo", "Tân", "Trần Linh", "Trần Bảo Ngọc", "Nghiêm Hương Giang", "Hoa", "hoàng mai thương", "Trịnh Văn Đạt", "Trang", "Thu Hà", "Tuyền hay ho", "Tuyền Bùi Công", "Nguyễn Tiến Hoàng", "Trung Lê", "Tiến Anh Vũ", "pnhung", "Đoàn Thị Minh Huyền", "Phú", "Ngọc Nguyễn", "Nguyễn Thị Yến", "Huờng", "trinh", "Huyền", "Thảo", "Phuong Anh Pham", "phạm lê vy", "tung", "Yến Nguyễn", "ngo vuong", "Đỗ Đặng Khánh", "Nguyễn Vân Anh", "Trung Trần", "Vương thị hoa", "Loan Nguyễn", "Loan Nguyễn", "Nguyễn Đình Ngọc Lâm", "Thu Huyền", "Nhi", "Hoàng Anh", "phương", "Hoa", "Hương", "Hải Đăng", "Dương Thản", "An Nguyễn", "Nông Chinh", "nguyễn thị uyên", "Hoàng Lâm", "Sơn Lê", "Thanh Nguyễn", "Mạnh", "Ly", "Nguyễn Phương Linh", "do trung hieu", "Nga", "Hồng", "Hong Hue", "Quỳnh", "Nguyễn Thị Diệu", "Nguyễn Nam", "Nguyễn Anh Tuấn", "Nhật Minh", "Định", "thạch thanh duy", "Nguyễn Đức Chung", "nguyen kim thanh5", "Phương", "Trương Thị Thúy Vân", "Thuỷ", "Tung Vu", "Ly Minh", "trinh loi", "dương văn thiết", "Đặng Văn Chương", "nguyễn mạnh tư", "My Nguyen", "tuấn", "đỗ đức vượng", "phạm huy", "Phạm Hiên", "Huyền Thanh", "Lee Nguyễn", "Tuấn ml", "Huy", "Long Lê", "Minh Hoàng", "mai anh", "Habeo", "Trần Thu Hương", "phuongdung", "Thủy", "Trần Hương", "hán ngọc phương linh", "Đặng Thu Hương", "Hà Nguyễn", "Ngọc Anh", "Ngọc Anh", "huy", "Khánh Nguyễn", "Nguyễn Sơn", "giang", "Châu Quang Minh", "ngọc", "Thu Trang", "Tung Thanh Phan", "Nguyễn Cường", "Nguyễn Thiện Quang", "Nguyễn Đình Việt", "Thanh Thanh", "Trần Kỳ Thư", "Ngọc Sơn", "Le Thang", "Đặng Kiên", "Trần Minh Thắngg", "Trần Tuấn Anh", "phạm thảo", "Huyền", "pham tuyen", "Trần Ngọc Hân", "lưu thị thương", "Nguyễn Trang Linh", "vũ thị thanh thanh", "Nguyễn Mai Anh", "Bùi Thuỳ Dung", "Trần Minh Thảo An", "Lê Tuyết Nhi", "Lê Tuyết Nhi", "Nhi Lê", "nguyễn Phương Nhi", "nguyễn Văn A", "trần minh tài", "Hương Đặng", "VyVy Huỳnh", "Nguyễn Đức Duy", "Huy Tiến Nguyễn", "Kẹo Bông", "NGUYỄN THỊ HẢI YẾN", "Nguyễn Thị Minh Thuý", "Kiều Thanh Hà", "Ngọc Anh", "Nguyễn Minh Thư", "Trịnh Tuấn Anh", "Vũ Sơn", "Phạm Phương Thùy", "vy", "my", "Trần Quyết", "Nguyễn Thị Tuyết Mai", "Dương", "Trương Quốc Thắng", "Nghiêm Phú Đạt", "Lưu Hiếu", "Lê Tùng", "Doãn Phan Giang", "Minh Nguyễn", "Hoàng Văn Ngọc", "Nguyễn Nhật Thiên", "phạm thị thanh lịch", "Hoàng Nam", "nguyễn thị thúy quỳnh", "Phương Phương", "đàm thị nhinh", "Lan Anh", "dương phương thảo", "mai", "Đỗ Thị Hiên", "Dương Nhật Ninh", "Vũ Diệu Hồng", "Nguyễn Nhi", "Dương Linh", "tạ thị kim liên", "Nguyễn Thị Ngọc Huyền", "Phan Hồng Ngọc", "Nguyễn Thị Nhung", "nguyễn thị ngọc ánh", "Đào Thị Thu Hương", "Phạm Hồng Nhung", "nguyen thu phuong", "Đinh Thị Thúy Loan", "Vũ Khánh Ly", "Nguyễn Trang", "trịnh hoài thu", "Tran Thao Ly", "Nguyễn Văn Cửu", "nguyễn thanh ngân", "đặng phương anh", "Hưng Phan Văn", "Lê Hoàng Yến", "Ngan Nguyen", "Thanh Ngọc", "Nguyễn Vũ Hà", "hoang dung", "Trần thị Thanh Tâm", "Lý Thanh Ngọc", "Ngọc Hải", "Quốc Khang", "Trung Trần", "Hoàng Như", "Trần Thư", "Bui Mai", "Lê Vy", "nguyễn thị như bình", "Phan Hau", "Hannah Trần", "Hoàng Thu Uyên", "Bành Quang Hùng", "Nguyễn Thị Loan", "Nguyen Do Trang Thy", "Trần Thị Hoàng Quyên", "Em Sẽ Sống Khác", "Nguyễn Thị Hà Thanh", "Huyen Thanh", "Lê Thị Hồng Nga", "Kevin Dang", "Lê Xuân Biên", "Phan thị thanh Huyền", "Trần Thị Chị Mai", "Khoảng Lặng", "loi triong", "hi hi", "lii tưi test", "truong loi", "Nguyễn Thị Thanh Tuyền", "Khang Cu", "thành hàng", "My Nguyễn", "Nguyễn Long", "Vũ Thắng.LD", "Thanh Tung", "NGUYỄN HỮU THANH", "Quan Bui", "Hiền Võ", "Anh Tú", "Kiên Thị Kim Anh", "Quoc Bao Le Hoang", "lê nguyễn minh tấn", "Toàn Đỗ", "Amy Nguyễn", "tuan e", "Thái An Khang", "Trong Anh", "Cơm Cháy Chiên", "Nguyễn Thủy", "Nguyễn Thị Hồng Lan", "Thien Duc Dao", "Phan Hoàng Thanh Hà", "Myla", "Myla", "ngọc", "Hồ Huỳnh Hồng Ngọc", "Ngoc", "Thanh Trúc", "Huy Phạm", "Nguyễn Ngọc Hưng", "Tống Thị Diễm", "dương tấn anh", "Huỳnh Tấn Sỹ", "Nguyễn Hoàng", "nguyễn phương thảo", "huỳnh thu hồng", "Tống Thị Kim Biên", "Hàn Ngữ Dong A", "Phillip Nguyễn", "Tuấn Dương", "Lương Kim Phuôn", "Hồng Nhiên", "Ngọc", "Trần Quốc Huy", "Thảo Thị Nguyễn", "Nmimi Huynh", "Yến Nguyễn", "Nguyễn Thị Kim Anh", "Loc Tran Loc Tran", "QNhư Như", "Xuan Anh", "nguyen thi huyen tran", "phan lê lâm trúc", "truong thi tron", "LE THI MONG CHINH", "Nguyễn Bảo Trân", "phamthimytrinh", "Nguyễn Bảo Trân", "NGUYEN THANH HAI", "Trần Đình Minh Trung", "Khoa Phan", "nguyễn thị mỹ anh", "Khiêm Trần Đức", "Thanh Xuân", "Nguyễn Thu Hương", "Lê Thị Thùy Ngân", "Trần Thị Minh Cúc", "nguyễn nhựt thông", "Trần Thị Minh Cúc", "Tô Tô", "Thu Hiền", "TThanh Nga", "Ngọc Khánh", "Phương Anh Ann", "Nguyễn Ngọc Uyên", "Tuyết Nguyễn", "trần thị phương", "Nguyễn Thoại Khanh", "Trịnh Phúc", "thanh nga", "nguyen thi thao nhi", "Phuc Vo", "Hương Giang", "Kim Trang Võ", "Võ Kim Thùy", "Út Lợi", "Trần Thị Mai", "Minh Thu Nguyen", "Ngọc Trần", "Nguyễn Nhựt Nam", "Nguyễn Nhựt Nam", "Luong Ngoc Baoha", "Trần Thị Hồng Hạnh", "Bi Bi", "Thảo Phạm", "Thanh Phong", "Lâm Hà", "Nguyễn Vũ", "Quyền", "Võ Thành Hưng", "Hoàng Minh Tùng", "Hoài Phương", "Phúc Nguyễn", "Phan hải nam", "Nguyễn Thuỷ", "Nguyễn Hoàng Long", "Duy Thanh", "Phương Nguyễn", "Cẩm Tú", "Tuấn Hà", "Nguyễn Nam", "Hoàng Hiếu", "Huy", "Lê Thanh Thúy", "Bảo Châu", "Đàm Huyền Trang", "Đàm Huyền Trang", "Vũ Hải Yến", "Ngoan", "nguyễn ngọc vũ", "Thu", "Trung", "Huệ", "Phạm Tuấn Quốc Thái", "Trang Dinh", "Vương Đình Khánh", "Đạt", "Hà Phương", "Như Nguyệtt", "nguyen Thuy Linh", "vũ khánh", "Quang Anh", "Lương Toàn Thắng", "Phú Thành", "Linh Chi", "Phú Thành", "Linh Chi", "Ha Nghia", "Phong", "Hùng", "Hà My", "Khôi", "Uyên", "Phú", "My Ha Nguyen", "Ngọc Hân", "Hà Thu Hương", "Ngọc", "Nguyễn Anh Duy", "Nguyễn Phương Mai", "Linh", "Trang Duong", "Tình", "Tuấn", "Tiến Ninh", "Thắng", "Thắng", "Trung", "Hằng", "Thủy Ngân", "Giáp Hoàng Anh", "Giáp Hoàng Anh", "Hải", "Dung Xinh", "Nhung", "Khánh Linh", "Nguyễn Yến", "Vân", "Sơn", "Ngọc Linh", "Nguyễn Giang", "Nguyễn Lập", "Nguyễn Duy Hưng", "Lưu Ngọc", "hoàng anh", "Mai Phương", "Trần Thị Hồng", "Hồng", "Lâm Hồng", "Nguyễn Phượng", "Lan Phương", "quỳnh", "Phạm Văn Minh", "Anh", "Hoàng", "Nguyễn Thành", "Khánh", "TÔM", "huy", "Nguyễn Việt Anh", "Hoàng Trần Huy Tùng", "chi", "Đoàn Linh Hoa", "Nguyen van phuong", "Phạm Minh hạnh", "Nguyễn Trang", "Tú", "La Tuấn Kiệt", "Nguyễn Thị Thu Trang", "Trần Vân Anh", "Nguyễn Trag", "Trung", "le duy thanh", "Nguyễn Thị Kiều Như", "Nguyễn Thuu Loan", "Nguyễn Thu Loan", "hoa", "Truong Loi", "thuỷ", "Bùi Quốc Trung", "Nguyễn Tử Dương", "Đức Nhật Nguyễn", "Trần Văn Quá", "Nguyen Dinh Chung", "NgaDo", "phương", "phuong", "Hoàng Hồng Lý", "NGUYỄN TIẾN THANH", "Dương", "Dao Gia Gia", "Hades Pruno", "Hương Nguyễn", "Nguyễn Quang Hòa", "Đăng", "Bùi Văn Thiện", "Nguyễn Phúc Thắng", "a", "Võ Nguyễn Thanh Lâm", "Nguyễn Đào", "Uyên", "hương", "Dương Ngọc Anh", "Vũ Cao Trọng Nhân", "lâm thị mỹ duyên", "Ngô Tuấn Anh", "Lâm Ngọc Thy", "dang diem huong", "NgTh Tâm", "Hà Thuỳ Trang", "Thành Eneos", "Nguyễn Đình Hưng", "Trần Quốc Huy", "Nguyễn Thu Trang", "Do Tran", "nguyễn thành long", "Đỗ Loan", "anh Dũng", "Trần Văn Sinh", "trung hieeus", "Hạnh", "Thùy Trang Nguyễn", "Nguyễn Hằng", "Hoa", "Hậu", "Thu Hiền", "Đạt", "Ngọc Ánh", "duy", "Thanh Thư", "Bùi Thị Oanh Oanh"];
    return $existName[array_rand($existName, 1)];
}

/**
 * Generate rating arrays
 */
function ratingRandom()
{
    $ratingNumber = rand(1, 3);
    $result = [];
    for ($i = 0; $i < $ratingNumber; $i++) {
        $result[] = rand(4, 5);
    }

    return $result;
}


function convertTimeToVND($dateTime)
{
    return date("Y-m-d H:i:s", strtotime('+7 hours', strtotime($dateTime)));
}


function isMobile()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}


function removeHyperLink($str) {
    return preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $str);
}

function convertViToEn($str) {
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
    $str = preg_replace("/(đ)/", "d", $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
    $str = preg_replace("/(Đ)/", "D", $str);
    //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
    return $str;
}