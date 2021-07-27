/**
 * FUNCTION CORE 
 * Funções primárias de interfase do template.
 */

$(function () {
    "use strict";
    $("#main-wrapper").AdminSettings({
        Theme: configTemplateColor,
        Layout: 'vertical',
        LogoBg: 'skin6',
        NavbarBg: 'skin6',
        SidebarType: configSidebar,
        SidebarColor: 'skin6',
        SidebarPosition: true,
        HeaderPosition: true,
        BoxedLayout: false
    });
});