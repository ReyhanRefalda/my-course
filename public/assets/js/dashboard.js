$(function () {
    var profit = {
        series: [
            {
                name: "Transaction",
                data: [9, 5, 3, 7, 5, 10, 3, 6, 8, 4, 7, 9],
            },
        ],
        chart: {
            type: "line",
            height: 370,
            fontFamily: "Poppins, sans-serif",
            toolbar: { show: false },
        },
        grid: {
            strokeDashArray: 3,
            borderColor: "rgb(0,0,0)",
        },
        colors: ["#3525B3"],
        plotOptions: {
            bar: {
                columnWidth: "30%",
                endingShape: "flat",
            },
        },
        dataLabels: { enabled: false },
        stroke: {
            show: true,
            width: 2,
            colors: ["#3525B3"],
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
            labels: { style: { colors: "#a1aab2" } },
            axisTicks: { show: false },
            axisBorder: { show: false },
        },
        yaxis: {
            labels: { style: { colors: "#a1aab2" } },
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
                        width: 3,
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
