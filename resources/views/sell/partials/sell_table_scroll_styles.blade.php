{{-- Contain DataTables scrollX inside the card (dark theme sets overflow:visible globally) --}}
<style>
    /* Outer card: clip only — real X scroll lives on .dataTables_scrollBody */
    body:not(.lockscreen) .vspos-sell-table-wrap.vspos-table-scroll-x,
    body:not(.lockscreen) .vspos-sell-table-wrap {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
        -webkit-overflow-scrolling: touch;
    }
    body:not(.lockscreen) .vspos-sell-table-wrap .dataTables_wrapper {
        width: 100% !important;
        max-width: 100% !important;
        overflow: visible !important;
    }
    body:not(.lockscreen) .vspos-sell-table-wrap div.dataTables_wrapper div.dataTables_scroll {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
    }
    body:not(.lockscreen) .vspos-sell-table-wrap div.dataTables_wrapper div.dataTables_scrollHead,
    body:not(.lockscreen) .vspos-sell-table-wrap div.dataTables_wrapper div.dataTables_scrollFoot {
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
    }
    /* Beat global overflow:visible — this is the element that must scroll horizontally */
    body:not(.lockscreen) .vspos-sell-table-wrap div.dataTables_wrapper div.dataTables_scrollBody,
    body:not(.lockscreen) .vspos-sell-table-wrap .dataTables_scrollBody {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: scroll !important;
        overflow-y: auto !important;
    }
    /* Do NOT force width:100% — table must grow wider than the card so scrollX works */
    body:not(.lockscreen) .vspos-sell-table-wrap table.dataTable {
        margin: 0 !important;
        width: auto !important;
        min-width: 100% !important;
    }
    body:not(.lockscreen) .vspos-sell-table-wrap table.dataTable thead th,
    body:not(.lockscreen) .vspos-sell-table-wrap table.dataTable tbody td,
    body:not(.lockscreen) .vspos-sell-table-wrap table.dataTable tfoot td {
        white-space: nowrap !important;
    }
</style>
