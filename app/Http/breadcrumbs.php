<?php

    // Dashboard
    Breadcrumbs::register('dashboard', function($breadcrumbs) {
        $breadcrumbs->push('Inicio');
    });

    // Users
    Breadcrumbs::register('users', function($breadcrumbs) {
        $breadcrumbs->push('Usuarios', URL::to('user'));
    });
    // Crear User
    Breadcrumbs::register('create_user', function($breadcrumbs) {
        $breadcrumbs->parent('users');
        $breadcrumbs->push('Nuevo');
    });
    // Edit User
    Breadcrumbs::register('edit_user', function($breadcrumbs) {
        $breadcrumbs->parent('users');
        $breadcrumbs->push('Editar');
    });

    // Contribution Rate
    Breadcrumbs::register('contribution_rates', function($breadcrumbs) {
        $breadcrumbs->push('Tasas de Aporte', URL::to('contribution_rate'));
    });

    // IPC Rate
    Breadcrumbs::register('ipc_rates', function($breadcrumbs) {
        $breadcrumbs->push('Tasas de Índice de Precio al Consumidor', URL::to('ipc_rate'));
    });

    // Base Wage
    Breadcrumbs::register('base_wages', function($breadcrumbs) {
        $breadcrumbs->push('Sueldos de Personal de la Policía Nacional', URL::to('base_wage'));
    });

    // Monthly Report
    Breadcrumbs::register('monthly_reports', function($breadcrumbs) {
        $breadcrumbs->push('Reporte Mensual de Totales', URL::to('monthly_report'));
    });

    // Affiliates
    Breadcrumbs::register('affiliates', function($breadcrumbs) {
        $breadcrumbs->push('Afiliados', URL::to('affiliate'));
    });
    // Show Affiliate
    Breadcrumbs::register('show_affiliate', function($breadcrumbs, $affiliate) {
        $breadcrumbs->parent('affiliates');
        $breadcrumbs->push($affiliate->getTittleName(), URL::to('affiliate/'.$affiliate->id));
    });

    // Show Contribution
    Breadcrumbs::register('show_contribution', function($breadcrumbs, $affiliate) {
        $breadcrumbs->parent('show_affiliate', $affiliate);
        $breadcrumbs->push('Aportes');
    });
    // Show Register Contribution
    Breadcrumbs::register('register_contribution', function($breadcrumbs, $affiliate) {
        $breadcrumbs->parent('show_affiliate', $affiliate);
        $breadcrumbs->push('Registro de Aporte');
    });
    //Show Direct Contributions
    Breadcrumbs::register('show_direct_contributions', function($breadcrumbs) {
        $breadcrumbs->push('Comprobantes de Aportes Directos', URL::to('aportepago'));
    });
    //Show Direct Contribution
    Breadcrumbs::register('show_direct_contribution', function($breadcrumbs, $affiliate) {
        $breadcrumbs->parent('show_affiliate', $affiliate);
        $breadcrumbs->push('Comprobante de Aporte Directo', URL::to('aportepago'));
    });

    //Show vouchers
    Breadcrumbs::register('show_vouchers', function($breadcrumbs) {
        $breadcrumbs->push('Comprobantes de Cobros', URL::to('voucher'));
    });
    //Show Voucher
    Breadcrumbs::register('show_voucher', function($breadcrumbs, $affiliate) {
        $breadcrumbs->parent('show_affiliate', $affiliate);
        $breadcrumbs->push('Comprobante de Cobro', URL::to('voucher'));
    });

    // Retirement Funds
    Breadcrumbs::register('retirement_funds', function($breadcrumbs) {
        $breadcrumbs->push('Trámites de Fondo de Retiro');
    });
    // Retirement Fund
    Breadcrumbs::register('retirement_fund', function($breadcrumbs, $affiliate) {
        $breadcrumbs->parent('show_affiliate', $affiliate);
        $breadcrumbs->push('Trámite de Fondo de Retiro');
    });
