jQuery(document).ready(function(jQuery) {
	jQuery(document).on("submit", "#commentform", function() {
        var e = jQuery(this);
        jQuery.ajax({
            url: globals.ajax_url,
            data: e.serialize() + "&action=ajax_comment",
            type: e.attr("method"),
            error: function(e) {
                ncPopupTips(0, e.responseText)
            },
            success: function(e) {
                jQuery("textarea").each(function() {
                    this.value = ""
                });
                var t = addComment,
                o = t.I("cancel-comment-reply-link"),
                r = t.I("wp-temp-form-div"),
                a = t.I(t.respondId),
                n = t.I("comment_post_ID").value,
                i = t.I("comment_parent").value;
                if (i != "0") {
                    jQuery("#respond").before('<ul class="children">' + e + "</ul>")
                } else if (!jQuery(".commentlist").length) {
                    jQuery("#respond").after('<ul class="commentlist">' + e + "</ul>")
                } else {
                    jQuery(".commentlist").append(e)
                }
                ncPopupTips(1, __.success)
                o.style.display = "none";
                o.onclick = null;
                t.I("comment_parent").value = "0";
                if (r && a) {
                    r.parentNode.insertBefore(a, r);
                    r.parentNode.removeChild(r)
                }
            }
        });
        return false
    });
    addComment = {
        moveForm: function(e, t, o) {
            var r = this,
            i, s = r.I(e),
            c = r.I(o),
            m = r.I("cancel-comment-reply-link"),
            l = r.I("comment_parent"),
            d = r.I("comment_post_ID");
            // a.text('再想想');
            r.respondId = o;
            if (!r.I("wp-temp-form-div")) {
                i = document.createElement("div");
                i.id = "wp-temp-form-div";
                i.style.display = "none";
                c.parentNode.insertBefore(i, c)
            } ! s ? (temp = r.I("wp-temp-form-div"), r.I("comment_parent").value = "0", temp.parentNode.insertBefore(c, temp), temp.parentNode.removeChild(temp)) : s.parentNode.insertBefore(c, s.nextSibling);
            jQuery("body").animate({
                scrollTop: jQuery("#respond").offset().top - 180
            },
            400);
            l.value = t;
            m.style.display = "";
            m.onclick = function() {
                var e = addComment,
                t = e.I("wp-temp-form-div"),
                o = e.I(e.respondId);
                e.I("comment_parent").value = "0";
                if (t && o) {
                    t.parentNode.insertBefore(o, t);
                    t.parentNode.removeChild(t)
                }
                this.style.display = "none";
                this.onclick = null;
                return false
            };
            try {
                r.I("comment").focus()
            } catch(u) {}
            return false
        },
        I: function(e) {
            return document.getElementById(e)
        }
    };
    window.addComment = addComment;
});
