
<style type="text/css">

    /*** @media all  ***/
    * {
        box-sizing: border-box;
    }
    html {
        height: 100%;
    }
    body {
        min-height: 100%;
        margin: 0;
        display: flex;
        flex-flow: column nowrap;
        justify-content: center;
        align-items: sretch;
        font: 12pt/1.5 'Raleway', 'Cambria', sans-serif;
        font-weight: 300;
        background: #fff;
        color: #666;
        -webkit-print-color-adjust: exact;
    }
    header {
        padding: 16px;
        position: relative;
        color: #888;
    }
    header h1,
    header h2 {
        font-weight: 200;
        margin: 0;
    }
    header h1 {
        font-size: 27pt;
        letter-spacing: 4px;
    }
    body > * {
        width: 100%;
        max-width: 7in;
        margin: 3px auto;
        background: #f0f0f0;
        text-align: center;
    }
    footer {
        padding: 16px;
    }
    footer p {
        font-size: 9pt;
        margin: 0;
        font-family: 'Nunito';
        color: #777;
    }
    section,
    table {
        padding: 8px 0;
        position: relative;
    }
    dl {
        margin: 0;
        letter-spacing: -4px;
    }
    dl dt,
    dl dd {
        letter-spacing: normal;
        display: inline-block;
        margin: 0;
        padding: 0px 6px;
        vertical-align: top;
    }
    dl.bloc > dt,
    dl:not(.bloc) dt:not(:last-of-type),
    dl:not(.bloc) dd:not(:last-of-type) {
        border-bottom: 1px solid #ddd;
    }
    dl:not(.bloc) dt {
        border-right: 1px solid #ddd;
    }
    dt {
        width: 49%;
        text-align: right;
        letter-spacing: 1px !important;
        overflow: hidden;
    }
    dd {
        width: 49%;
        text-align: left;
    }
    dd,
    tr>td {
        font-family: 'Nunito';
    }
    section.flex {
        display: flex;
        flex-flow: row wrap;
        padding: 8px 16px;
        justify-content: space-around;
    }
    dl.bloc {
        padding: 0;
        flex: 1;
        vertical-align: top;
        min-width: 240px;
        margin: 0 8px 8px;
    }
    dl.bloc>dt {
        text-align: left;
        width: 100%;
        margin-top: 12px;
    }
    dl.bloc>dd {
        text-align: left;
        width: 100%;
        padding: 8px 0 5px 16px;
        line-height: 1.25;
    }
    dl.bloc>dd>dl dt {
        width: 33%;
    }
    dl.bloc>dd>dl dd {
        width: 60%;
    }
    dl.bloc dl {
        margin-top: 12px;
    }
    dl.bloc dd {
        font-size: 11pt;
    }
    table {
        width: 100%;
        padding: 0;
        border-spacing: 0px;
    }
    table tr {
        margin: 0;
        padding: 0;
        background: #fdfdfd;
        border-right: 1px solid #ddd;
        width: 100%;
    }
    table tr td,
    table tr th {
        border: 1px solid #e3e3e3;
        border-top: 1px solid #fff;
        border-left-color: #fff;
        font-size: 11pt;
        background: #fdfdfd;
    }
    table thead th {
        background: #e9e9e9;
        background: linear-gradient(to bottom, #f9f9f9, #e9e9e9) !important;
        font-weight: 300;
        letter-spacing: 1px;
        padding: 15px 0 5px;
        /*&:not(:last-child)*/
        border: none !important;
    }
    table tbody tr:last-child td {
        border-bottom: 1px solid #ddd;
    }
    table tbody td {
        min-width: 75px;
        padding: 3px 6px;
        line-height: 1.25;
    }
    table tfoot tr td {
        /*border 1px solid #e3e3e3
              border-top 1px solid white
              border-left-color #fff*/
        height: 40px;
        padding: 6px 0 0;
        color: #000;
        text-shadow: 0 0 1px rgba(0,0,0,0.25);
        font-family: 'Cambria', 'Raleway', sans-serif;
        font-weight: 400;
        letter-spacing: 1px;
    }
    table tfoot tr td:first-child {
        font-style: italic;
        color: #997b7b;
    }
    a {
        color: #992c2c;
    }
    a:hover {
        color: #b00;
    }
    @page {
        margin: 0.5cm;
    }
    /*** @media screen  ***/
    html,
    body {
        background: #333231;
    }
    header:before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        border-top: 12px solid #333;
        border-left: 12px solid #ddd;
        width: 0;
        box-shadow: 1px 1px 2px rgba(0,0,0,0.18);
    }

</style>
<page backtop="10mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <head>
    <meta charset="UTF-8">
    <title>Facture José Roux</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300|Raleway:200,300", rel="stylesheet", type="text/css")>
    </head>

    <body>

    </body>

    <header>
       <h1>FACTURE</h1>
        <h2> José Roux − Interactive Design</h2>
    </header>
    <section class="flex">
   <dl>
        <dt>Facture #</dt>
        <dd>20140603</dd>
        <dt>Date de facturation</dt>
        <dd>03.06.2014</dd>
   </dl>
    </section>

    <section class="flex">
        <dl class="bloc")>
            <dt> Facturé à:</dt>
            <dd>
                Company X &amp; Son Inc.<br>
                2789 Some street,<br>
                Big City, Québec, J3X 1J1
            </dd>
            <dl>
                <dt>Attn</dt>
                <dd>Le Big Boss</dd>
                <dt>Téléphone</dt>
                <dd>(450) 555-2663</dd>
                <dt>Courriel</dt>
                <dd></dd>

            </dl>

        </dl>

    dl
    dt Attn
    dd Le Big Boss
    dt Téléphone
    dd (450) 555-2663
    dt Courriel
    dd bigboss@bigcompanylonglongemail.com
    dl(class="bloc")
    dt Description de service:
    dd Développement AIR
    dt Période totale:
    dd 24 Mai au 2 Juin 2014

    table
    thead
    tr
    th Période
    th Description
    th Heures
    th Taux
    th Montant
    tbody
    tr
    td 24 Mai au 2 Juin
    td Dévelopement du jeu Tomatina
    td 24&#8202;h
    td 20&#8202;$/h
    td 480&#8202;$
    tfoot
    tr
    td(colspan="3") − Faire les chèques payable au nom de moi −
    td Total:
    td 480&#8202;$

    footer
    p Moi – Informatique − Développement WEB | <a href="http://joseroux.com">joseroux.com</a>
    p 1777 some street in the woods, Wentworth-Nord, Qc, J0T 1Y0 | Tél. 450-555-1000 | <a href="mailto:mail@me.com">mail@me.com</a>


</page>