$(document).ready(function () {
    const _token = $('meta[name="csrf-token"]').attr("content");

    // Switchery
    $(".js-switch").each(function () {
        const switchery = new Switchery(this, { color: "#1AB394" });
    });

    // Select 2
    $(".setupSelect2").select2();

    // SortUI
    $("#sortable").sortable();
    $("#sortable").disableSelection();

    // Check All
    $(document).on("click", "#checkAll", function () {
        const isChecked = $(this).prop("checked");

        $(".checkBoxItem")
            .prop("checked", isChecked)
            .each(function () {
                changeBackground($(this));
            });
    });

    // Chech Box Item
    $(document).on("click", ".checkBoxItem", function () {
        const allCheck =
            $(".checkBoxItem:checked").length === $(".checkBoxItem").length;
        $("#checkAll").prop("checked", allCheck);

        changeBackground($(this));
    });

    // Change Status
    $(document).on("change", ".status", function () {
        const _this = $(this);
        const options = {
            value: _this.val(),
            modelId: _this.attr("data-modelId"),
            model: _this.attr("data-model"),
            field: _this.attr("data-field"),
            _token,
        };

        $.ajax({
            type: "POST",
            url: "ajax/memberManagement/changeStatus",
            data: options,
            dataType: "json",
            success: function (response) {
                if (response.flag) {
                    _this.val(options.value == 2 ? 1 : 2);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Lỗi: " + textStatus + " " + errorThrown);
            },
        });
    });

    // Change Status All
    $(document).on("click", ".changeStatusAll", function (e) {
        const id = [];

        $(".checkBoxItem").each(function () {
            const checkBoxIsChecked = $(this).prop("checked");
            if (checkBoxIsChecked) {
                id.push($(this).val());
            }
        });

        const options = {
            id,
            value: $(this).attr("data-value"),
            model: $(this).attr("data-model"),
            field: $(this).attr("data-field"),
            _token,
        };

        $.ajax({
            type: "POST",
            url: "ajax/memberManagement/changeStatusAll",
            data: options,
            dataType: "json",
            success: function (response) {
                if (response.flag) {
                    const spanSwitcheryActive =
                        "background-color: rgb(26, 179, 148);border-color: rgb(26, 179, 148);box-shadow: rgb(26, 179, 148) 0px 0px 0px 16px inset;transition: border 0.4s, box-shadow 0.4s, background-color 1.2s;";
                    const smallSwitcheryActive =
                        "left: 20px;background-color: rgb(255, 255, 255);transition: background-color 0.4s, left 0.2s;";
                    const spanSwitcheryUnactive =
                        "box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; border-color: rgb(223, 223, 223); background-color: rgb(255, 255, 255); transition: border 0.4s, box-shadow 0.4s;";
                    const smallSwitcheryUnactive =
                        "left: 0px; transition: background-color 0.4s, left 0.2s;";
                    if (options.value == 1) {
                        for (let key in id) {
                            $(".js-switch-" + id[key])
                                .find("span.switchery")
                                .attr("style", spanSwitcheryActive)
                                .find("small")
                                .attr("style", smallSwitcheryActive);
                        }
                    } else if (options.value == 2) {
                        for (let key in id) {
                            $(".js-switch-" + id[key])
                                .find("span.switchery")
                                .attr("style", spanSwitcheryUnactive)
                                .find("small")
                                .attr("style", smallSwitcheryUnactive);
                        }
                    }

                    // Unactive checked
                    $(".checkBoxItem:checked")
                        .prop("checked", false)
                        .closest("tr")
                        .removeClass("active-bg");
                    if ($("#checkAll").prop("checked")) {
                        $("#checkAll").prop("checked", false);
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Lỗi: " + textStatus + " " + errorThrown);
            },
        });
    });

    // Change Background
    const changeBackground = (_this) => {
        const isChecked = _this.prop("checked");

        if (isChecked) {
            _this.closest("tr").addClass("active-bg");
        } else {
            _this.closest("tr").removeClass("active-bg");
        }
    };
});
