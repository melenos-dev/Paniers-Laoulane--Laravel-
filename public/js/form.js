$(function () {
    const Switch = $("input[name='switch_price']");
    const price = $("input[name='product_price'");
    const total_price = $("input[name='product_total_price'");

    Switch.on("change", function (e) {
        let prec = Switch.val();
        $("div[id='" + prec + "']").slideUp();
        let next =
            prec == "product_total_price"
                ? "product_price"
                : "product_total_price";
        $("div[id='" + next + "']").slideDown();
        price.val("");
        total_price.val("");
        Switch.val(next);
    });

    Switch.on("click", "[data-showTarget]", function (e) {
        e.stopPropagation();
        target = $(this).attr("data-showTarget");
        target = $("#" + target);
        if (target.is(":visible")) {
            if ($(this).is(":checkbox")) {
                if ($(this).prop("checked", true)) {
                    $(this).prop("checked", false);
                    target.hide(300);
                }
            } else target.hide(300);
        } else {
            if ($(this).is(":checkbox")) {
                if ($(this).prop("checked", false)) {
                    $(this).prop("checked", true);
                    target.show(300);
                    target.children().focus();
                }
            } else target.show(300);
        }
    });
});
