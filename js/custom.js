function showProgress(val) {
    if (val == 0) {
        $("#progressInfo").css('visibility', 'hidden');
        $("#progressInfo").addClass('shrink-height');
        $(".forward").text('Mulai');
    } else {
        $("#progressInfo").css('visibility', 'visible');
        $("#progressInfo").removeClass('shrink-height');
        $(".forward").text('Selanjutnya');
    }
}

function switch_method(val) {
    if (val == true) {
        $("#select_method").show();
        $("#instruct_assessment").hide();
        $("#bottom-wizard").hide();
    } else {
        $("#select_method").hide();
        $("#instruct_assessment").show();
        $("#bottom-wizard").show();
    }
}

function updateProcess(val){
    $("#process_status").text(val);
}

function scrape(val, url) {
    updateProcess("Mengunduh tweet pengguna");
    if (val != '' && val != null) {
        $.ajax({
            url: url + "scrape",
            type: "POST",
            data: { user: val } ,
            dataType: 'json', // added data type
            success: function (response) {
                // console.log(response);
                if (response['message'] == 'success') {
                    cleaning(val, url);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown); 
                updateProcess('Maaf terjadi kesalahan, kamu bisa refresh halaman untuk mengulangi!');
            }
        });
    }
}

function cleaning(val, url) {
    updateProcess("Membersihkan dan menyatukan tweet");
    if (val != '' && val != null) {
        $.ajax({
            url: url + "preprocess",
            type: "POST",
            data: { user: val } ,
            dataType: 'json', // added data type
            success: function (response) {
                // console.log(response);
                if (response['message'] == 'success') {
                    predict(val, url);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown); 
                updateProcess('Maaf terjadi kesalahan, kamu bisa refresh halaman untuk mengulangi!');
            }
        });
    }
}

function predict(val, url) {
    updateProcess("Memprediksi jenis kepribadian pengguna");
    if (val != '' && val != null) {
        $.ajax({
            url: url + "predict",
            type: "POST",
            data: { user: val } ,
            dataType: 'json', // added data type
            success: function (response) {
                // console.log(response);
                if (response['message'] == 'success') {
                    insertDb(response);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown); 
                updateProcess('Maaf terjadi kesalahan, kamu bisa refresh halaman untuk mengulangi!');
            }
        });
    }
}

function insertDb(val) {
    updateProcess("Menyimpan hasil ke database");
    $.ajax({
        url: '?act=test&type=auto',
        type: 'POST',
        data:{
            'data': val['data'],
            'result': val['result']
        }
    });
}