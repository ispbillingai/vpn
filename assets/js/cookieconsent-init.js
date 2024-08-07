"use strict";
var base_url = window.location.origin;

// obtain cookieconsent plugin
var cc = initCookieConsent();

// run plugin with config object
cc.run({
    current_lang: 'en',
    autoclear_cookies: true,                    // default: false
    cookie_name: 'webguard_cookie_consent',     // default: 'cc_cookie'
    cookie_expiration: 365,                     // default: 182
    page_scripts: true,                         // default: false
    force_consent: true,                        // default: false

    auto_language: 'browser',                   // default: null; could also be 'browser' or 'document'
    // autorun: true,                           // default: true
    // delay: 0,                                // default: 0
    // hide_from_bots: false,                   // default: false
    // remove_cookie_tables: false              // default: false
    // cookie_domain: location.hostname,        // default: current domain
    // cookie_path: '/',                        // default: root
    // cookie_same_site: 'Lax',
    // use_rfc_cookie: false,                   // default: false
    // revision: 0,                             // default: 0

    gui_options: {
        consent_modal: {
            layout: 'cloud',                    // box,cloud,bar
            position: 'bottom center',          // bottom,middle,top + left,right,center
            transition: 'slide'                 // zoom,slide
        },
        settings_modal: {
            layout: 'bar',                      // box,bar
            position: 'left',                   // right,left (available only if bar layout selected)
            transition: 'slide'                 // zoom,slide
        }
    },

    onFirstAction: function(){
        console.log('onFirstAction fired');
    },

    onAccept: function (cookie) {
        console.log('onAccept fired!')
    },

    onChange: function (cookie, changed_preferences) {
        console.log('onChange fired!');

        // If analytics category is disabled => disable google analytics
        if (!cc.allowedCategory('analytics')) {
            typeof gtag === 'function' && gtag('consent', 'update', {
                'analytics_storage': 'denied'
            });
        }
    },

    languages: {
        'en': {
            consent_modal: {
                title: 'Hello, let\'s allow your cookies!',
                description: 'Our website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only after consent. <a href="#privacy-policy" class="cc-link">Privacy policy</a>',
                primary_btn: {
                    text: 'Accept all',
                    role: 'accept_all'      //'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'Preferences',
                    role: 'settings'       //'settings' or 'accept_necessary'
                },
                revision_message: '<br><br> Dear user, terms and conditions have changed since the last time you visisted!'
            },
            settings_modal: {
                title: 'Cookie settings',
                save_settings_btn: 'Save current selection',
                accept_all_btn: 'Accept all',
                reject_all_btn: 'Reject all',
                close_btn_label: 'Close',
                cookie_table_headers: [
                    {col1: 'Name'},
                    {col2: 'Domain'},
                    {col3: 'Expiration'}
                ],
                blocks: [
                    {
                        title: 'Cookie usage',
                        description: 'Our website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only after consent. <a href="#" class="cc-link">Privacy Policy</a>.'
                    }, {
                        title: 'Strictly necessary cookies',
                        description: '',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true  //cookie categories with readonly=true are all treated as "necessary cookies"
                        },
                        cookie_table: [
                            {
                                col1: 'webguard_cookie',
                                col2: base_url,
                                col3: '5 minutes',
                                is_regex: true
                            },
                            {
                                col1: 'ci_session',
                                col2: base_url,
                                col3: '5 minutes',
                            },
                            {
                                col1: 'webguard_cookie_consent',
                                col2: base_url,
                                col3: '365 days',
                            }
                        ]
                    }, {
                        title: 'Analytics & Performance cookies',
                        description: '',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        },
                        cookie_table: [
                            {
                                col1: '^_ga',
                                col2: 'https://google.com',
                                col3: '2 years',
                                is_regex: true
                            },
                            {
                                col1: '^_gid',
                                col2: 'https://google.com',
                                col3: '24 hours',
                            },
                            {
                                col1: '^_gat',
                                col2: 'https://google.com',
                                col3: '1 minute',
                            }
                        ]
                    }, {
                        title: 'Targeting & Advertising cookies',
                        description: 'If this category is deselected, <b>the page will reload when preferences are saved</b>... <br><br>(demo example with reload option enabled, for scripts like microsoft clarity which will re-set cookies and send beacons even after the cookies have been cleared by the cookieconsent\'s autoclear function)',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false,
                            reload: 'on_disable'            // New option in v2.4, check readme.md
                        },
                        cookie_table: [
                            {
                                col1: '^_cl',               // New option in v2.4: regex (microsoft clarity cookies)
                                col2: 'https://microsoft.com',
                                col3: 'These cookies are set by microsoft',
                                // path: '/',               // New option in v2.4
                                is_regex: true              // New option in v2.4
                            }
                        ]
                    }, {
                        title: 'More information',
                        description: 'If you have any questions, contact us at <a class="cc-link" href="https://orestbida.com/contact/">Contact me</a>.',
                    }
                ]
            }
        },
        'pt': {
            consent_modal: {
                title: 'Olá, vamos permitir seus cookies!',
                description: 'Nosso site usa cookies essenciais para garantir seu funcionamento adequado e cookies de rastreamento para entender como você interage com ele. Este último será definido somente após consentimento. <a href="#privacy-policy" class="cc-link">Política de Privacidade</a>',
                primary_btn: {
                    text: 'Permitir Todos',
                    role: 'accept_all'      //'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'Preferências',
                    role: 'settings'       //'settings' or 'accept_necessary'
                },
                revision_message: '<br><br> Caro usuário, os termos e condições mudaram desde a última vez que você visitou!'
            },
            settings_modal: {
                title: 'Configurações Cookie',
                save_settings_btn: 'Salvar Secionados',
                accept_all_btn: 'Permitir Todos',
                reject_all_btn: 'Rejeitar Todos',
                close_btn_label: 'Fechar',
                cookie_table_headers: [
                    {col1: 'Nome'},
                    {col2: 'Domínio'},
                    {col3: 'Expiração'}
                ],
                blocks: [
                    {
                        title: 'Uso dos Cookies',
                        description: 'Nosso site usa cookies essenciais para garantir seu funcionamento adequado e cookies de rastreamento para entender como você interage com ele. Este último será definido somente após consentimento. <a href="#" class="cc-link">Política de Privacidade</a>.'
                    }, {
                        title: 'Cookies estritamente necessários',
                        description: '',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true  //cookie categories with readonly=true are all treated as "necessary cookies"
                        },
                        cookie_table: [
                            {
                                col1: 'webguard_cookie',
                                col2: base_url,
                                col3: '5 minutos',
                                is_regex: true
                            },
                            {
                                col1: 'ci_session',
                                col2: base_url,
                                col3: '5 minutos',
                            },
                            {
                                col1: 'webguard_cookie_consent',
                                col2: base_url,
                                col3: '365 dias',
                            }
                        ]
                    }, {
                        title: 'Cookies analíticos e de desempenho',
                        description: '',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        },
                        cookie_table: [
                            {
                                col1: '^_ga',
                                col2: 'https://google.com',
                                col3: '2 anos',
                                is_regex: true
                            },
                            {
                                col1: '^_gid',
                                col2: 'https://google.com',
                                col3: '24 horas',
                            },
                            {
                                col1: '^_gat',
                                col2: 'https://google.com',
                                col3: '1 minuto',
                            }
                        ]
                    }, {
                        title: 'Cookies de segmentação e publicidade',
                        description: 'Se esta categoria for desmarcada, <b>a página será recarregada quando as preferências forem salvas</b>... <br><br>(exemplo de demonstração com a opção de recarga habilitada, para scripts como o Microsoft Clear que redefinirá os cookies e enviará beacons mesmo depois que os cookies tiverem sido limpos pela função de limpeza automática do cookieconsent)',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false,
                            reload: 'on_disable'            // New option in v2.4, check readme.md
                        },
                        cookie_table: [
                            {
                                col1: '^_cl',               // New option in v2.4: regex (microsoft clarity cookies)
                                col2: 'https://microsoft.com',
                                col3: 'Esses cookies são definidos pela microsoft',
                                // path: '/',               // New option in v2.4
                                is_regex: true              // New option in v2.4
                            }
                        ]
                    }, {
                        title: 'Mais Informações',
                        description: 'Caso tenha qualquer dúvida fale conosco em <a class="cc-link" href="https://orestbida.com/contact/">Contate-me</a>.',
                    }
                ]
            }
        },
        'es': {
            consent_modal: {
                title: '¡Hola, permitamos las cookies!',
                description: 'Nuestro sitio web utiliza cookies esenciales para garantizar su correcto funcionamiento y cookies de seguimiento para comprender cómo interactúa con él. Este último se fijará sólo después del consentimiento. <a href="#privacy-policy" class="cc-link">Política de privacidad</a>',
                primary_btn: {
                    text: 'Permitir Todo',
                    role: 'accept_all'      //'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'Preferencias',
                    role: 'settings'       //'settings' or 'accept_necessary'
                },
                revision_message: '<br><br> Estimado usuario, ¡los términos y condiciones han cambiado desde la última vez que visitó!'
            },
            settings_modal: {
                title: 'Configuración de Cookies',
                save_settings_btn: 'Guardar Seccionado',
                accept_all_btn: 'Permitir Todo',
                reject_all_btn: 'Rechazar Todo',
                close_btn_label: 'Cerrar',
                cookie_table_headers: [
                    {col1: 'Nombre'},
                    {col2: 'Dominio'},
                    {col3: 'Vencimiento'}
                ],
                blocks: [
                    {
                        title: 'Uso de cookies',
                        description: 'Nuestro sitio web utiliza cookies esenciales para garantizar su correcto funcionamiento y cookies de seguimiento para comprender cómo interactúa con él. Este último se fijará sólo después del consentimiento. <a href="#" class="cc-link">Política de privacidad</a>.'
                    }, {
                        title: 'Cookies estrictamente necesarias',
                        description: '',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true  //cookie categories with readonly=true are all treated as "necessary cookies"
                        },
                        cookie_table: [
                            {
                                col1: 'webguard_cookie',
                                col2: base_url,
                                col3: '5 minutos',
                                is_regex: true
                            },
                            {
                                col1: 'ci_session',
                                col2: base_url,
                                col3: '5 minutos',
                            },
                            {
                                col1: 'webguard_cookie_consent',
                                col2: base_url,
                                col3: '365 días',
                            }
                        ]
                    }, {
                        title: 'Cookies analíticas y de rendimiento',
                        description: '',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        },
                        cookie_table: [
                            {
                                col1: '^_ga',
                                col2: 'https://google.com',
                                col3: '2 años',
                                is_regex: true
                            },
                            {
                                col1: '^_gid',
                                col2: 'https://google.com',
                                col3: '24 horas',
                            },
                            {
                                col1: '^_gat',
                                col2: 'https://google.com',
                                col3: '1 minuto',
                            }
                        ]
                    }, {
                        title: 'Cookies de segmentación y publicidad',
                        description: 'Si esta categoría no está marcada, <b>la página se volverá a cargar cuando se guarden las preferencias</b>... <br><br>(ejemplo de demostración con la opción de recarga habilitada, para scripts como Microsoft Clear, que restablecerá las cookies y enviará balizas incluso después de que la función de limpieza automática de cookieconsent haya borrado las cookies)',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false,
                            reload: 'on_disable'            // New option in v2.4, check readme.md
                        },
                        cookie_table: [
                            {
                                col1: '^_cl',               // New option in v2.4: regex (microsoft clarity cookies)
                                col2: 'https://microsoft.com',
                                col3: 'Estas cookies las establece microsoft',
                                // path: '/',               // New option in v2.4
                                is_regex: true              // New option in v2.4
                            }
                        ]
                    }, {
                        title: 'Mas Informaciones',
                        description: 'Si tiene alguna pregunta, contáctenos en <a class="cc-link" href="https://orestbida.com/contact/">Contáctame</a>.',
                    }
                ]
            }
        }
    }
});