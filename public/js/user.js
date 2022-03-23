$(document).ready(function () {
    var loginRecordDate = 7;
    var token = $('meta[name="csrf-token"]').attr('content');
    var userId = $("#userId").attr("value");

    $('#userDataSearch').click(function () {
        userEmail = $("#userEmail").val();

        $('#userDataDetail').load('/userDataDetailAjax', {
            'user_email': userEmail, '_token': token,
        }, function (response, status, xhr) {
            if (response.length > 50) {
                myChart = echarts.init(document.getElementById('main'));
                userId = $("#userId").attr("value");
                adminLoginRecord(userId, loginRecordDate);
            }
        });
    });

    $("#userDataDetail").on('change', '#recordDate', function () {
        loginRecordDate = $("#recordDate option:selected").val();
        adminLoginRecord(userId, loginRecordDate);
    });

    function adminLoginRecord() {
        window.onresize = function () {
            myChart.resize();
        };
        $.ajax({
            url: "/userLoginRecordAjax",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "userId": userId,
                "recordDay": loginRecordDate,
            },
            success: function (result) {
                var option = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: { type: 'cross' }
                    },
                    xAxis: {
                        name: '登录日期',
                        data: result['date']
                    },
                    yAxis: {
                        name: '登陆次数'
                    },
                    series: [
                        {
                            name: '登陆次数',
                            type: 'line',
                            data: result['times'],
                        }
                    ]
                };

                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);
            }
        });
    }
});