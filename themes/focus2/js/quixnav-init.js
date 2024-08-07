(function($) {
    "use strict"
    let theme = localStorage.getItem("theme");
    let direct = localStorage.getItem("direction");
    new quixSettings({
        typography: "roboto",
        version: (theme === undefined || theme == null || theme.length <= 0) ? "light" : "dark",
        layout: "vertical",
        headerBg: "color_1",
        navheaderBg: "color_1",
        sidebarBg: "color_1",
        sidebarStyle: "full",
        sidebarPosition: "fixed",
        headerPosition: "fixed",
        containerLayout: "wide",
        direction: (direct === undefined || direct == null || direct === "rtl") ? "rtl" : "ltr"
    });
})(jQuery);