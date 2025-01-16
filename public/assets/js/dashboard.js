// chart transaction
$(function () {
    const rawTransactionData = $("#profit").data("transactions");
    const transactionData = rawTransactionData || [
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
    ]; // Data fallback

    if (!rawTransactionData || !Array.isArray(transactionData)) {
        console.error("Transaction data is not valid:", rawTransactionData);
        return; // Stop script jika data tidak valid
    }

    var profit = {
        series: [
            {
                name: "Transaction",
                data: transactionData, // Data dinamis
            },
        ],
        chart: {
            type: "bar",
            height: 350,
            fontFamily: "Poppins, sans-serif",
            toolbar: { show: false },
        },
        grid: {
            strokeDashArray: 3,
            borderColor: "rgba(0,0,0,0.1)",
        },
        colors: ["#3525B3"],
        plotOptions: {
            bar: {
                columnWidth: "20%",
                endingShape: "flat",
            },
        },
        dataLabels: { enabled: false },
        stroke: {
            show: true,
            width: 3,
            colors: ["#3525B3"],
            curve: "smooth",
        },
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "Mei",
                "Jun",
                "Jul",
                "Agu",
                "Sep",
                "Okt",
                "Nov",
                "Des",
            ],
            labels: { style: { colors: "#707070" } },
            axisTicks: { show: false },
            axisBorder: { show: false },
        },
        yaxis: {
            labels: {
                style: { colors: "#707070" },
                formatter: function (value) {
                    return Math.round(value); // Membulatkan angka ke bilangan bulat
                },
            },
        },
        fill: {
            opacity: 1,
            colors: ["#3525B3"],
        },
        tooltip: { theme: "dark" },
        legend: { show: false },
        responsive: [
            {
                breakpoint: 767,
                options: {
                    stroke: {
                        width: 5,
                    },
                },
            },
        ],
    };

    var chartColumnBasic = new ApexCharts(
        document.querySelector("#profit"),
        profit
    );
    chartColumnBasic.render();
});

// chart balance
$(function () {
    const rawBalanceData = $("#balance-chart").data("balance");
    const balanceData =
        rawBalanceData || Array(12).fill({ owner: 0, teacher: 0 });

    const ownerBalanceData = balanceData.map((item) => item.owner);
    const teacherBalanceData = balanceData.map((item) => item.teacher);

    var balanceOptions = {
        chart: {
            type: "line",
            height: 350,
            fontFamily: "Poppins, sans-serif",
        },
        series: [
            {
                name: "Balance (Owner)",
                data: ownerBalanceData,
            },
            {
                name: "Balance (Teacher)",
                data: teacherBalanceData,
            },
        ],
        stroke: {
            width: 3,
            curve: "smooth",
        },
        xaxis: {
            categories: [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ],
        },
        colors: ["#3525B3", "#F77E21"],
    };

    var balanceChart = new ApexCharts(
        document.querySelector("#balance-chart"),
        balanceOptions
    );
    balanceChart.render();
});

// Chart Student
// $(function () {
//     const rawStudentData = $("#student-chart").data("students");
//     const studentData = rawStudentData || Array(12).fill(0);

//     var studentChartOptions = {
//         chart: {
//             type: "bar",
//             height: 350,
//             fontFamily: "Poppins, sans-serif",
//         },
//         series: [
//             {
//                 name: "Students",
//                 data: studentData,
//             },
//         ],
//         colors: ["#28a745"],
//         xaxis: {
//             categories: [
//                 "January",
//                 "February",
//                 "March",
//                 "April",
//                 "May",
//                 "June",
//                 "July",
//                 "August",
//                 "September",
//                 "October",
//                 "November",
//                 "December",
//             ],
//         },
//     };

//     var studentChart = new ApexCharts(
//         document.querySelector("#student-chart"),
//         studentChartOptions
//     );
//     studentChart.render();
// });
