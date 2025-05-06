$(document).ready(function () {
    "use strict";

    // CKEditor 4
    if ($(".ck-editor")) {
        $(".ck-editor").each(function () {
            const elementId = $(this).attr("id");
            const elementHeight = $(this).attr("data-height");
            CKEDITOR.replace(elementId, {
                height: elementHeight,
                removeButtons: "",
                entities: true,
                allowedContent: true,
                toolbarGroups: [
                    {
                        name: "editing",
                        groups: ["find", "selection", "spellchecker", "undo"],
                    },
                    { name: "links" },
                    { name: "insert" },
                    { name: "forms" },
                    { name: "tools" },
                    {
                        name: "document",
                        groups: ["mode", "document", "doctools"],
                    },
                    { name: "others" },
                    {
                        name: "basicstyles",
                        groups: [
                            "basicstyles",
                            "cleanup",
                            "colors",
                            "styles",
                            "indent",
                        ],
                    },
                    {
                        name: "paragraph",
                        groups: ["list", "", "blocks", "align", "bidi"],
                    },
                ],
            });
        });
    }

    // Upload image avatar
    $(".image-target").click(function () {
        const type = "Images";
        browseServerAvatar($(this), type);
    });

    const browseServerAvatar = (object, type) => {
        if (typeof type == "undefined") {
            type = "Images";
        }
        const finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl, data) {
            object.attr("src", fileUrl);
            object.siblings("input").val(fileUrl);
        };

        finder.popup();
    };

    // Upload image
    $(".upload-image").click(function () {
        const type = $(this).attr("data_type");
        setUpCkFinder2($(this), type);
    });

    const setUpCkFinder2 = (object, type) => {
        if (typeof type == "undefined") {
            type = "Images";
        }
        const finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl, data) {
            object.val(fileUrl);
        };

        finder.popup();
    };

    // Upload Mutiple Image CKEditor
    $(document).on("click", ".multipleUploadImageCKeditor", function (e) {
        const object = $(this);
        const target = object.attr("data-target");
        browseServerCkeditor(object, "Images", target);
        e.preventDefault();
    });

    const browseServerCkeditor = (objet, type, target) => {
        if (typeof type == "undefined") {
            type = "Images";
        }
        const finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl, data, allFiles) {
            let html = "";
            for (let i = 0; i < allFiles.length; i++) {
                const image = allFiles[i].url;
                html += '<div class="image-content"><figure>';
                html += '<img src="' + image + '" alt="' + image + '">';
                html += "<figcaption>Nhập vào mô tả cho ảnh</figcaption>";
                html += "</div></figure>";
            }
            CKEDITOR.instances[target].insertHtml(html);
        };

        finder.popup();
    };

    // Upload Picture
    $(".upload-picture").click(function (e) {
        const type = "Images";
        browseServerAlbum(type);
        e.preventDefault();
    });

    const browseServerAlbum = (type) => {
        if (typeof type == "undefined") {
            type = "Images";
        }
        const finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function (fileUrl, data, allFiles) {
            let html = "";
            for (let i = 0; i < allFiles.length; i++) {
                const image = allFiles[i].url;
                html += '<li class="ui-state-default">';
                html += ' <div class="thumb">';
                html += '<span class="span image img-scaledown">';
                html += '<img src="' + image + '" alt="' + image + '">';
                html +=
                    '<input type="hidden" name="album[]" value="' +
                    image +
                    '">';
                html += "</span>";
                html += '<button class="delete-image">';
                html += ' <i class="fa fa-trash"></i>';
                html += "</button>";
                html += "</div>";
                html += "</li>";
            }
            $(".click-to-upload").addClass("hidden");
            $("#sortable").append(html);
            $(".upload-list").removeClass("hidden");
        };

        finder.popup();
    };

    // Delete Picture
    $(document).on("click", ".delete-image", function () {
        $(this).parents(".ui-state-default").remove();
        if ($(".ui-state-default").length == 0) {
            $(".click-to-upload").removeClass("hidden");
            $(".upload-list").addClass("hidden");
        }
    });
});
