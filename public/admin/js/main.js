function ChangeToSlug()
{
    var title, slug;

    title = document.getElementById("title").value;

    slug = title.toLowerCase();

    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, " - ");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    slug = slug.replace(/\s/g, '');
    //In slug ra textbox có id “slug”
    document.getElementById('slug').value = slug;
}

$(document).ready(function() {
    // $('#title').keyup(function() {
    //     ChangeToSlug();
    // });

    // update checkbox status
    $("input[type='checkbox']").change(function() {
        $(this).attr('checked', this.checked);
    });

    $('.switch').on('change', function() {
        var is_new_comment = $(this).find('.is_new_comment').attr('checked');
        if (is_new_comment == 'checked') {
            is_new_comment = 1;
        } else {
            is_new_comment = 2;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "/admin/fb-posts/update-new-comment",
            data: { is_new_comment, post_id: $(this).find('.post_id').val()}
        }).done(function( msg ) {
            if (msg) {
                $('.rating .txt').html(msg);
            }
        });
    })

    $('.reply-link a').on('click contextmenu focus', function() {
        var reply_id = $(this).attr('reply-id');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "/admin/replies/read",
            data: { reply_id: reply_id, is_read: 2}
        }).done(function( msg ) {
            return;
        });
    })

    $('.comment-link a').on('click contextmenu focus', function() {
        var comment_id = $(this).attr('comment-id');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "/admin/comments/read",
            data: { comment_id: comment_id, is_read: 2}
        }).done(function( msg ) {
            return;
        });
    })

    
    $(".admin-product input[type='submit']").on('click', function(e){
        var preview = $(this).attr('preview');
        e.preventDefault();
        form = $(this).closest("form");
        if (preview == 1) {
            formAction = form.attr('action');
            form.attr("action", formAction+'?preview=1').submit();
        }
        form.submit();
    });
    $("textarea, input[name='seo_description']").keyup(function(e) {
        var label = $(e.target).parent().find("label");
        var hasCount = label.find(".count");
        if (hasCount.html()) {
            hasCount.html(e.target.value.length);
        } else {
            label.append(" <span class='count'>"+e.target.value.length+"</span>")
        }
    });

    $("input[id='seo_title']").keyup(function(e) {
        var label = $(e.target).parent().find("label");
        var hasCount = label.find(".count");
        if (hasCount.html()) {
            hasCount.html(e.target.value.length);
        } else {
            label.append(" <span class='count'>"+e.target.value.length+"</span>")
        }
    });

    $(".chosen-select").chosen();
    
    var providerID = $(".provider-select").val();
    console.log(providerID);
    if (providerID) {
        $(".provider").css("display", "none");
    } else {
        $(".provider").css("display", "block");
    }

    $(".provider-select").on("change", function() {
        var providerID = $(this).val();
        if (providerID) {
            $(".provider").css("display", "none");
        } else {
            $(".provider").css("display", "block");
        }
    });
})
