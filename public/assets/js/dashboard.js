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
            height: 370,
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
            labels: { style: { colors: "#707070" } },
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
