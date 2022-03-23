<?php

namespace App\Console;

use App\Constant;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\RatingNews;
use App\Models\Product;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {  
        $schedule->call(function () {
            $comments = ["Cám ơn Thảo Mộc Uy Tín đã giới thiệu cho tôi lọ $1 này",
                    "Chưa biết $1 hiệu quả ra sao nhưng dịch vụ với khách hàng tốt.",
                    "Riêng $1 thì dùng rất yên tâm, nhất là mua ở nhà thuốc uy tín thế này.",
                    "Đã nghe $1 từ khá lâu nhưng giờ mới sử dụng. Hi vọng uống cái này có hiệu quả",
                    "Phải nói là dân mình bây giờ chịu khó chăm sóc sức khỏe thật đấy, hôm trước qua nhà thuốc mà $1 này đã cháy hàng, hôm sau quay lại mới có.",
                    "Nhà thuốc giao hàng rất nhanh, sp $1 đầy đủ tem nhãn, check đc mã vạch để biết hàng chuẩn.",
                    "Mình nhận được hàng rồi nhà thuốc nhé! $1 đầy đủ thông tin nhãn mác mã vạch, rất yên tâm sử dụng ạ!",
                    "Bác sĩ tư vấn nhiệt tình quá, cảm ơn Thảo Mộc Uy Tín",
                    "Nhà thuốc giao hàng nhanh, đóng gói cẩn thận. Cảm ơn Thảo Mộc Uy Tín",
                    "$1 dùng ổn lắm nhà thuốc ạ, giá lại rẻ hơn so với mình mua lần trước",
                    "$1 dùng khá tốt, vẫn đang theo dùng thường xuyên",
                    "Nhà thuốc giao hàng nhanh, $1 có tem nhãn đầy đủ như hình. Rất yên tâm sử dụng!",
                    "Nhà thuốc giao hàng nhanh, đóng gói $1 rất cẩn thận. Cảm ơn NT",
                    "Nhà thuốc giao hàng rất nhanh, đóng gói cẩn thận rất yên tâm khi sử dụng $1 của Thảo Mộc Uy Tín!",
                    "Viên uống hiệu quả, mình dùng thấy cải thiện hơn rất nnhieefu. Thanks Thảo Mộc Uy Tín",
                    "Nhà thuốc giao hàng nhanh, hàng có tem nhãn chống hàng giả, đóng gói cẩn thận. Rất tin tưởng nhà thuốc!",
                    "Mua $1 số lượng nhiều thì giá bao nhiêu Nhà Thuốc ơi?",
                    "$1 dùng tốt, hàng có tem nhãn đầy đủ nên rất yên tâm sử dụng.",
                    "Thiệt tình là lúc đặt là mình đang mua $1 và cũng đang buồn ngủ nên chả để ý tới việc có kèm quà tặng, lúc nhận hàng xem lại xem mình có đặt thêm mấy món này không thì mới biết là quà đính kèm, ưng cái bụng lắm, cám ơn nhà thuốc",
                    "Vận chuyển nhanh, Đóng gói cẩn thận, Hi vọng dùng $1 sẽ có tác dụng",
                    "Chưa uống nên chưa biết $1 có hiệu quả không. Giao hàng siu nhanh luôn.",
                    "Đóng gói kĩ, anh shiper giao hàng dễ thương vãi luôn. Cảm ơn Thảo Mộc Uy Tín",
                    "mình cực kì ưng nha, đóng gói đẹp. Giao hàng nhanh và ưu đãi tốt. Mình từng uống qua $1 này khi ở Nhật nên mình rất may mắn khi tìm mua được. Thanks Nhà Thuốc",
                    "Thảo Mộc Uy Tín đóng gói cẩn thật thật đấy. Thanks nhiều.",
                    "Giao hàng nhanh đóng gói cẩn thận sản phẩm $1 rất chất lượng. Mình đã dùng và thấy rat hiệu quả sẽ ủng hộ nhà thuốc thêm nữa, đánh giá 5 sao",
                    "$1 tốt giá cả hợp lí đóng gói cẩn thận giao hàng rất nhanh mình rất thích sẽ ủng hộ nhà thuốc thêm nữa",
                    "Nhan duoc $1 roi nha thuoc nhe san pham ok lam, nha thuoc giao hang nhanh nua san pham sung dang 5 sao nhe ",
                    "Chất lượng $1 tuyệt vời, đóng gói sản phẩm rất cẩn thận, nhà thuốc tư vấn nhiệt tình, thời gian giao hàng khá nhanh chóng, giá cả cũng phải chăng, rất đáng tiền, rất hài lòng sẽ ủng hộ nha thuoc thêm nữa",
                    "Dùng $1 có hiệu quả mình sẽ tiếp tục ủng hộ nhà thuốc và giới thiệu cho bạn bè",
                    "$1 có tem chống hàng giả, chất lượng, mà không có hdsd của nhà thuốc",
                    "Lần thứ 3 mua $1 của nhà thuốc rùi. Giao hàng siêu nhanh, hàng chính hãng 100%. ",
                    "Đúng $1 chính hãng, mình đã mua hộp thứ 2 của nhà thuốc rồi",
                    "nhà thuốc giao nhanh, đã cào $1 lấy mã check, đúng hàng chính hãng, thanks nhà thuốc.",
                    "Hàng giao siêu nhanh. Vừa đặt hôm qua hôm nay đã giao tới liền. $1 được đóng gói cẩn thận. Check được mã vạch hàng chuẩn auth ạ.",
                    "$1 có dán tem chống giả và có cào mã số kiểm tra nên rất là yên tâm",
                    "Mình mua $1 biếu người nha, hi vọng dùng tốt để lần tới mình mua thêm",
                    "Đã mua $1 nhiều lần, gt cho họ hàng sửa dụng và tin tưởng, giao hàng nhanh",
                    "Thuốc $1 chưa sử dụng nhưng lọ date dài, mẫu mới ",
                    "nhà thuốc tư vấn nhiệt tình. Đóng gói $1 chắc chắn. ",
                    "Giao hàng rất nhanh, nhà thuốc cũng gửi hình và hsd $1 trước khi gửi hàng rất đàng hoàng",
                    "Chưa dùng nên không biết có hiệu quả không, nhưng $1 tới thời gian, đúng mẫu và đúng hình",
                    "Đóng gói chắc chắn lắm. Nếu $1 tốt thì lại ok quá vì giá rẻ mà",
                    "Đã nhận được em nó. Thật giả không biết, chưa dùng $1 bao giờ nhưng đóng gói cẩn thận. Rất tin tưởng Thảo Mộc Uy Tín",
                    "$1 tốt, mẹ dùng 1 tháng đã thấy hiệu quả. Tin tưởng nhà thuốc nên đã mua rất nhiều.",
                    "Nhà thuốc giao $1 nhanh, đã mua lại lần thứ 2 của Thảo Mộc Uy Tín",
                ];

            $productModel = new Product();
            $products = $productModel->getNewest([], 10000)->get()->toArray();
            $randomProductIndex = rand(0, count($products)-1);
            $randomCommentIndex = rand(0, count($comments)-1);
            $randomComment = $comments[$randomCommentIndex];
            $randomProduct = $products[$randomProductIndex];
            $keywords = $randomProduct['seo_keyword'];
            $productName = "";
            try {
                $tmpKeyword = explode(",", $keywords);
                $productName = $tmpKeyword[0];
            } catch (\Throwable $th) {
                //throw $th;
            }
            $randomComment = str_replace('$1', $productName, $randomComment);

            $rating = new Rating();
            $rating->product_id = $randomProduct['id'];
            $rating->rating = rand(4,7) > 4 ? 5: 4;
            $rating->customer_name = RandomCustomerName();
            $rating->content = $randomComment;
            $rating->ip = "127.0.0.1";
            $rating->is_admin = 2;
            $randTime = '+00:'.rand(1,59);
            $rating->created_at = Carbon::now($randTime);
            $rating->updated_at = Carbon::now($randTime);
            $rating->save();

            // Clean redis
            $cachedKeyMobile = "mobile_".$randomProduct['slug'];
            $cachedKeyDesktop = "desktop_".$randomProduct['slug'];
            try {
                Redis::del(Redis::keys($cachedKeyMobile));
            } catch (\Throwable $th) {
                // do nothing
            }
            try {
                Redis::del(Redis::keys($cachedKeyDesktop));
            } catch (\Throwable $th) {
                // do nothing
            }
            
        })->name('create_comment')->withoutOverlapping();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
