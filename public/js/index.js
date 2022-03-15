$(document).ready(function () {
    var loginRecordDate = '7';
    var adminId = $("#adminId").attr("value");

    var myChart = echarts.init(document.getElementById('main'));
    window.onresize = function () {
        myChart.resize();
    };

    adminLoginRecord(adminId, loginRecordDate);

    $("#recordDate").change(function () {
        loginRecordDate = $("#recordDate option:selected").val();
        adminLoginRecord(adminId, loginRecordDate);
    });

    function adminLoginRecord() {
        $.ajax({
            url: "/adminLoginRecordAjax",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "adminId": adminId,
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