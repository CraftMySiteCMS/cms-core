<?php $title = _Pages_add_TITLE;
$description = _Pages_add_DESC; ?>

<?php $scripts = '<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script><!-- Header -->

    <script src="https://cdn.jsdelivr.net/npm/@editorjs/image@latest"></script><!-- Image -->

    <script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@latest"></script><!-- Delimiter -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script><!-- List -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script><!-- Quote -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/code@latest"></script><!-- Code -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/table@latest"></script><!-- Table -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/link@latest"></script><!-- Link -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/warning@latest"></script><!-- Warning -->

    <script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script><!-- Embed -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/marker@latest"></script><!-- Marker -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/underline@latest"></script><!-- Underline -->

    <script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/editorjs/plugins/drag-drop.js"></script><!-- DragDrop -->
    <script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/editorjs/plugins/undo.js"></script><!-- Undo -->


    <!-- Load Editor.js Core -->
    <script src="'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/editorjs/editor.js"></script>
    <!-- Initialization -->
    <script>
    let editor = new EditorJS({
        placeholder: "Commencez à taper ou cliquez sur le \"+\" pour choisir un bloc à ajouter...",
        logLevel: "ERROR",
        readOnly: false,
        holder: "editorjs",
        /**
         * Tools list
         */
        tools: {
            header: {
                class: Header,
                config: {
                    placeholder: "Entrer un titre",
                    levels: [2, 3, 4],
                    defaultLevel: 2
                }  
            },
            image: {
                class: ImageTool,
                config: {
                    uploader: {
                        uploadByFile(file) {
                        let formData = new FormData();
                        formData.append("file", file, file["name"]);
                        return fetch("'.getenv("PATH_SUBFOLDER").'admin/resources/vendors/editorjs/upload_file.php", {
                            method:"POST",
                            body:formData
                        }).then(res=>res.json())
                            .then(response => {
                                return {
                                    success: 1,
                                    file: {
                                        url: "'.getenv("PATH_SUBFOLDER").'public/uploads/"+response
                                    }
                                }
                            })
                        }
                    }
                }
            },
            list: List,
            quote: {
                class: Quote,
                config: {
                    quotePlaceholder: "",
                    captionPlaceholder: "Auteur",
                },
            },
            warning: Warning,
            code: CodeTool,
            delimiter: Delimiter,
            linkTool: LinkTool,
            table: Table,
            embed: {
                class: Embed,
                config: {
                    services: {
                        youtube: true,
                        coub: true
                    }
                }
            },
            Marker: Marker,
            underline: Underline,
        },
        defaultBlock: "paragraph",

        /**
         * Initial Editor data
         */
        data: {},
        onReady: function(){
            new Undo({ editor });
            const undo = new Undo({ editor });
            new DragDrop(editor);
        },
        onChange: function() {}
    });

    /**
     * Saving button
     */
    const saveButton = document.getElementById("saveButton");

    /**
     * Saving action
     */
    saveButton.addEventListener("click", function () {
        
        editor.save()
        .then((savedData) => {
            $.ajax({
                url : "'.getenv("PATH_SUBFOLDER").'cms-admin/pages/add",
                type : "POST",
                data : {
                    "news_title" : "TEST TITRE",
                    "news_slug" : "test_titre",
                    "news_content" : JSON.stringify(savedData)
                },
                success: function (data) {
                    alert("L\'actualité a bien été sauvegardée !");
                }
            });
        })
        .catch((error) => {
            console.error("Saving error", error);
        });
    });
    </script>'; ?>

<?php ob_start(); ?>
<style>
    .ce-block__content, .ce-toolbar__content {
        max-width: 80%!important;
    }
    .page-title {
        width: 80%;
        margin: 0 10%;
        font-size: 30px;
        border: 0;
        margin-bottom: 10px;
    }
</style>
    <!-- main-content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-9">
                    <div class="card card-primary">
                        <div class="card-body">
                            <input class="page-title" type="text" id="title" placeholder="Titre de la page">
                            <p class="page-slug"><?php echo "http://" . $_SERVER['SERVER_NAME'] . '/'; ?> <input class="border-0" type="text" id="slug"></p>
                            <div class="ce-example__content _ce-example__content--small">
                                <div id="editorjs"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="btn btn-block btn-primary" id="saveButton">
                                <?=_Pages_button_save?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.main-content -->
<?php $content = ob_get_clean(); ?>

<?php require(getenv("PATH_ADMIN_VIEW") . 'template.php'); ?>