$(document).ready(function () {
    $(document).on("change", ".location", function () {
        const _this = $(this);
        const options = {
            data: {
                location_id: _this.val(),
            },
            target: _this.attr("data-target"),
        };

        handleSendData(options);
    });

    const handleSendData = (options) => {
        $.ajax({
            type: "GET",
            url: "ajax/location/getLocation",
            data: options,
            dataType: "json",
            success: function (response) {
                $("." + options.target).html(response.html);
                if (district_id != 0 && options.target == "districts") {
                    $(".districts").val(district_id).trigger("change");
                } else if (ward_id != 0 && options.target == "wards") {
                    $(".wards").val(ward_id);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Lỗi: " + textStatus + " " + errorThrown);
            },
        });
    };

    // Load City
    if (province_id != 0) {
        $(".provinces").val(province_id).trigger("change");
    }
});
