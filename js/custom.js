$(document).ready(function () {
//    function filter() {
//        $("#filename").change(function (e) {
//            var ext = $("input#filename").val().split(".").pop().toLowerCase();
//
//            if ($.inArray(ext, ["csv"]) == -1) {
//                alert('Upload CSV');
//                return false;
//            }
//
//            if (e.target.files != undefined) {
//                var reader = new FileReader();
//                reader.onload = function (e) {
//                    var csvval = e.target.result.split(",");
//
//                    var dataObject = [];
//                    var obj = [];
//                    var rows = e.target.result.split("\n");
//                    for (var i = 0; i < rows.length; i++) {
//                        // this line helps to skip empty rows
//                        if (rows[i]) {
//                            // our columns are separated by comma
//                            var column = rows[i].split(",");
//
//                            // column is array now 
//                            // first item is date
//
//                            var date = column[0];
//                            // second item is value of the second column
//                            var value = column[1];
//                            var v = column[2];
//                            var b = column[3];
//                            var c = column[4];
//
//                            dataObject.push({
//                                date: date,
//                                visits: value,
//                                v: v,
//                                b: b,
//                                c: c,
//                            });
//                            if (i > 2) {
//                                $.each(dataObject, function (key, val) {
//
//                                    if (val.visits == value) {
//                                       
//                                        console.log(dataObject[key]);
//
//                                    }
//
//
//
//
//                                })
//                            }
//
//                        }
//
//                    }
//
//
//
//                }
//                ;
//                reader.readAsText(e.target.files.item(0));
//
//            }
//
//            return false;
//
//        });
//
////        $("#submits").on("click", function () {
////            var sub = $(".files").val();
////            $.post("sitefile", {val: sub}, function (data) {
////                console.log(data);
//////                var array = jQuery.parseJSON(data);
////////
////////                //access your data like this:
////////                var plum = data_array['mod']; 
//////                var list = [];
//////                var f = [];
//////                $.each(array, function (key, value) {
//////
//////                    list.push(value.id + "=>" + value.data_id)
//////
//////                })
//////                var uniq = list.reduce(function (a, b) {
//////                    if (a.indexOf(b) < 0)
//////                        a.push(b);
//////                    return a;
//////                }, []);
//////
//////                for (var c = 0; c < uniq.length; c++) {
//////                    $(".right").append("<div>" + uniq[c] + "</div>")
//////                }
////
////            });
////        })
//    }
//    filter();




    function datas(data) {
        if (typeof data != 'object') {
            var url = location.host
            $("#audio-element").attr({
                'src': "/mp3/" + data
            })
            //$(".play ").append("<audio controls><source src=" + url + "/mp3/" + data + " type='audio/mp3'> </source></audio>");
        }
        var obj = jQuery.parseJSON(data);
        if (obj != "undefined") {
            $(".mp3songs div").remove();
            $.each(obj, function (key, value) {

                $(".mp3songs ").append("<div class='names'><a>" + value.name + "</a></div>");
                if (key == 0) {
                    $("#audio-element").attr({
                        'src': "/mp3/" + value.name
                    })

                }
            }
            );
        }
        click();
    }
    function click() {
        $(".names a").on("click", function () {
            $(".names a").css({"background": "blue"});
            var html = $(this).html();
            $("#audio-element").attr({
                'src': "/mp3/" + html
            })
            $(this).css({"background": "red"});
            lime();
        })
        function lime() {
            var colors = ['#2E8B57', "red", "black", "green"];

            $(".lime").on("click", function () {
                var ind = $(this).index();
                if (ind > 3) {
                    var key = $(this).children("a").html();
                    var keys = localStorage.key(key)
                    var value = localStorage[key];
                    var val = value.split(",")
                    $(".mp3 div").remove();
                    var arr2 = [];
                    var arr3 = [];
                    for (var h = 1; h <= val.length; h++) {
                        if (h % 2) {
                            $(".mp3 ").append("<div style='\n\
                          width:" + val[h - 1] + ";\n\
                          float:left;\n\
                          height:30px;\n\
                          background:" + colors[Math.floor(Math.random() * colors.length)] + ";'>\n\
                           <a class='catsa'>" + val[h] + "-" + val[h - 1] + "</a>\n\
                        </div>");
                            arr2.push(val[h]);
                            arr3.push(val[h - 1]);
                        }
                    }

                }
            })
        }
        lime();

    }

    function clickNext() {
        $("#next").on("click", function () {

            var audio = $("#audio-element").attr('src')
            var str = audio.split("/");
            var l = $(".savemp3 div").length;


            if (l == 0) {

                $(".savemp3").eq(0).append("<div class='lime' ><a >" + str[2] + "</a></div>");

                $(".categories div select").each(function (x) {
                    if ($(this).val() > 0) {
                        var cats = $(this).val();
                        $(".lime").append("<span>" + cats + "</span>");


                    }
                });
            } else {
                var h = "<div class='lime' ><a >" + str[2] + "</a></div>";
                $(".savemp3 ").children("div").each(function (x) {

                    var ht = $(this).children("a").html();
                    if (ht == str[2]) {
                        $(this).remove();
                        localStorage.removeItem(str[2]);
                    }

                });
                $(".savemp3 ").children().eq(0).after(h);
                var htm = $(".savemp3 ").children().eq(1).children("a").html();
                var array = [];
                var row = [];

                $(".categories div select").each(function (x) {
                    if ($(this).val() > 0 && str[2] == htm) {
                        var cats = $(this).val() + "0%";
                        var num = $(this).parent().children("a").html();
                        $(".lime").eq(0).append("<span> " + cats + ",</span>");
                        array.push(cats, num);
                        row.push(cats, num);

                    }
                });
                localStorage.setItem(str[2], row, array);

            }


        })

    }
    clickNext();

    function posts() {
        var arr = [];

        var cat = [];
        $(".categories div select").each(function (x) {
            if ($(this).val() > 0) {
                var cats = $(this).parent().children("a").html();
                arr.push($(this).val());
                cat.push(cats);

            }
        });


    }
    $(window).load(function () {
        $.post("site/add", {name: "q"}, function (data) {
            if (data) {
                datas(data);
            }
        });

        for (var i = 0; i < localStorage.length; i++) {
            console.log();
            $(".savemp3").append("<div class='lime' >\n\
                                       <a >" + localStorage.key(i) + "</a>\n\
                                        <span>" + localStorage.getItem(localStorage.key(i)) + "</span>\n\
                                  </div>");

        }
    });

    $("form#audio_form").submit(function (event) {

        event.preventDefault();
        //grab all form data  
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: 'site/add',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data) {
                    datas(data);
                }
            }
        });
        return false;
    });


    var i = 0
    $(".playCategorie").on("click", function () {
        $(".mp3 div").remove();
        var arr = [];
        var l = 0
        var cat = [];
        $(".categories div select").each(function (x) {

            l += Number($(this).val());
            if ($(this).val() > 0) {
                var cats = $(this).parent().children("a").html();
                arr.push($(this).val());
                cat.push(cats);

            }
        })
        var width = $(".play").width() / arr.length;
        var ar = [];
        var colors = ['#2E8B57', "red", "black", "green"];
        if (l <= 10) {
            for (var i = 0; i < arr.length; i++) {
                var j = (100 * Number(arr[i]) / 10);
                ar.push(j);
                $(".mp3").append("\
                       <div style='\n\
                          width:" + j + "%;\n\
                          float:left;\n\
                          height:30px;\n\
                          background:" + colors[Math.floor(Math.random() * colors.length)] + ";'>\n\
                           <a class='catsa'>" + cat[i] + "-" + j + "%</a>\n\
                        </div>");
            }
        } else {
            alert("the count of   numbers should not exeed 10")
        }

    });

});
