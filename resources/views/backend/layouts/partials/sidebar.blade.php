 @php
     $usr = Auth::guard('admin')->user();
 @endphp
 <div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <h2 class="text-white">AKIWACU</h2> 
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">

                    @if ($usr->can('dashboard.view'))
                    <li class="active">
                        <a href="{{ route('admin.dashboard') }}" aria-expanded="true"><i class="ti-dashboard"></i><span>@lang('messages.dashboard')</span></a>
                    </li>
                    @endif
                    <!-- start musumba steel menu -->
                    @if ( $usr->can('musumba_steel_facture.create') || $usr->can('musumba_steel_facture.view') ||  $usr->can('musumba_steel_facture.edit') ||  $usr->can('musumba_steel_facture.delete') ||  $usr->can('musumba_steel_facture.validate') ||  $usr->can('musumba_steel_facture.confirm') ||  $usr->can('musumba_steel_facture.send') ||  $usr->can('musumba_steel_facture.approuve'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-shopping-cart"></i><span>
                            @lang('MUSUMBA FACTURES')
                        </span></a>
                        <ul class="collapse">
                                @if ($usr->can('musumba_steel_facture.view'))
                                <li class=""><a href="{{ route('admin.musumba-steel-item-categories.index') }}"><i class="fa fa-first-order"></i>&nbsp;@lang('Categories')</a></li>
                                @endif 
                                @if ($usr->can('musumba_steel_facture.view'))
                                <li class=""><a href="{{ route('admin.musumba-steel-items.index') }}"><i class="fa fa-first-order"></i>&nbsp;@lang('Articles')</a></li>
                                @endif
                                @if ($usr->can('musumba_steel_facture.view'))
                                <li class=""><a href="{{ route('admin.musumba-steel-clients.index') }}"><i class="fa fa-first-order"></i>&nbsp;@lang('Clients')</a></li>
                                @endif
                                @if ($usr->can('musumba_steel_facture.view'))
                                <li class=""><a href="{{ route('admin.musumba-steel-facture.index') }}"><i class="fa fa-first-order"></i>&nbsp;@lang('Factures')</a></li>
                                @endif
                        </ul>
                    </li>
                    @endif
                    @if ($usr->can('musumba_steel_car.create') || $usr->can('musumba_steel_car.view') ||  $usr->can('musumba_steel_car.edit') ||  $usr->can('musumba_steel_car.delete') || $usr->can('musumba_steel_material_supplier.create') || $usr->can('musumba_steel_material_supplier.view') ||  $usr->can('musumba_steel_material_supplier.edit') ||  $usr->can('musumba_steel_fuel_supplier.view'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-shopping-basket"></i><span>
                            @lang('messages.basic_file')
                        </span></a>
                        <ul class="collapse">
                                @if($usr->can('musumba_steel_material_supplier.view'))
                                <li class=""><a href="{{ route('admin.ms-material-suppliers.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Fournisseurs Materiels')</a></li>
                                @endif
                                @if($usr->can('musumba_steel_fuel_supplier.view'))
                                <li class=""><a href="{{ route('admin.ms-fuel-suppliers.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Fournisseurs Carburant')</a></li>
                                @endif
                                @if($usr->can('musumba_steel_material_supplier.view'))
                                <li class=""><a href="{{ route('admin.ms-material-category.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Categorie Materiel')</a></li>
                                @endif
                                @if($usr->can('musumba_steel_material_supplier.view'))
                                <li class=""><a href="{{ route('admin.ms-materials.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Materiel')</a></li>
                                @endif
                                @if($usr->can('musumba_steel_car.view'))
                                <li class=""><a href="{{ route('admin.ms-cars.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Car')</a></li>
                                @endif
                                @if($usr->can('musumba_steel_driver.view'))
                                <li class=""><a href="{{ route('admin.ms-drivers.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Driver')</a></li>
                                @endif
                                <!--
                                @if($usr->can('musumba_steel_driver_car.view'))
                                <li class=""><a href="{{ route('admin.ms-driver-cars.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Driver&amp;Car')</a></li>
                                @endif
                            -->
                                @if($usr->can('musumba_steel_fuel.view'))
                                <li class=""><a href="{{ route('admin.ms-fuels.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Fuel')</a></li>
                                @endif
                                @if($usr->can('musumba_steel_index_pump.view'))
                                <li class=""><a href="{{ route('admin.ms-fuel-index-pumps.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Index Pump')</a></li>
                                @endif
                        </ul>
                    </li>
                    @endif
                    @if ($usr->can('musumba_steel_material_store.create') || $usr->can('musumba_steel_material_store.view') ||  $usr->can('musumba_steel_material_store.edit') ||  $usr->can('musumba_steel_material_store.delete') || $usr->can('musumba_steel_fuel_pump.create') || $usr->can('musumba_steel_fuel_pump.view') ||  $usr->can('musumba_steel_fuel_pump.edit') ||  $usr->can('musumba_steel_fuel_pump.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-shopping-basket"></i><span>
                            @lang('messages.stock')
                        </span></a>
                        <ul class="collapse">
                                @if($usr->can('musumba_steel_material_store.view'))
                                <li class=""><a href="{{ route('admin.ms-material-store.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Materiels')</a></li>
                                @endif
                                @if($usr->can('musumba_steel_fuel_pump.view'))
                                <li class=""><a href="{{ route('admin.ms-fuel-pumps.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Fuel Pump')</a></li>
                                @endif
                        </ul>
                    </li>
                    @endif
                    @if ($usr->can('musumba_steel_material_inventory.create') || $usr->can('musumba_steel_material_inventory.view') ||  $usr->can('musumba_steel_material_inventory.edit') ||  $usr->can('musumba_steel_material_inventory.delete') || $usr->can('musumba_steel_fuel_inventory.create') || $usr->can('musumba_steel_fuel_inventory.view') ||  $usr->can('musumba_steel_fuel_inventory.edit') ||  $usr->can('musumba_steel_fuel_inventory.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-list"></i><span>
                            @lang('messages.inventory')
                        </span></a>
                        <ul class="collapse">
                                @if($usr->can('musumba_steel_material_inventory.view'))
                                <li class=""><a href="{{ route('admin.ms-material-store-inventory.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Stock Materiels (Grand)')</a></li>
                                @endif
                                @if($usr->can('musumba_steel_fuel_inventory.view'))
                                <li class=""><a href="{{ route('admin.ms-fuel-inventories.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Fuel Inventory')</a></li>
                                @endif

                        </ul>
                    </li>
                    @endif
                    @if ($usr->can('mmusumba_steel_material_requisition.create') || $usr->can('mmusumba_steel_material_requisition.view') ||  $usr->can('mmusumba_steel_material_requisition.edit') ||  $usr->can('mmusumba_steel_material_requisition.delete') || $usr->can('musumba_steel_fuel_requisition.create') || $usr->can('musumba_steel_fuel_requisition.view'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-list"></i><span>
                            @lang('messages.requisition')
                        </span></a>
                        <ul class="collapse">
                            <!--
                                @if($usr->can('musumba_steel_material_requisition.view'))
                                <li class=""><a href="{{ route('admin.ms-material-requisitions.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Materiels')</a></li>
                                @endif
                            -->
                                @if($usr->can('musumba_steel_fuel_requisition.view'))
                                <li class=""><a href="{{ route('admin.ms-fuel-requisitions.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Fuel Requisition')</a></li>
                                @endif

                        </ul>
                    </li>
                    @endif
                    @if ( $usr->can('musumba_steel_material_reception.create') || $usr->can('musumba_steel_material_reception.view') ||  $usr->can('musumba_steel_material_reception.edit') ||  $usr->can('musumba_steel_material_reception.delete') ||  $usr->can('musumba_steel_material_purchase.view') ||  $usr->can('musumba_steel_material_purchase.create') ||  $usr->can('musumba_steel_material_supplier_order.view') ||  $usr->can('musumba_steel_material_supplier_order.create') ||  $usr->can('musumba_steel_fuel_reception.view') ||  $usr->can('musumba_steel_fuel_supplier_order.view') ||  $usr->can('musumba_steel_fuel_purchase.view'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-shopping-cart"></i><span>
                            @lang('messages.purchases')
                        </span></a>
                        <ul class="collapse">
                                @if ($usr->can('musumba_steel_material_purchase.view'))
                                <li class=""><a href="{{ route('admin.ms-material-purchases.index') }}"><i class="fa fa-first-order"></i>&nbsp;@lang('Demande Achat Materiel')</a></li>
                                @endif
                                @if ($usr->can('musumba_steel_fuel_purchase.view'))
                                <li class=""><a href="{{ route('admin.ms-fuel-purchases.index') }}"><i class="fa fa-first-order"></i>&nbsp;@lang('Demande Achat Carburant')</a></li>
                                @endif
                                @if ($usr->can('musumba_steel_material_supplier_order.view'))
                                <li class=""><a href="{{ route('admin.ms-material-supplier-orders.index') }}"><i class="fa fa-first-order"></i>&nbsp;@lang('Commande Materiel')</a></li>
                                @endif
                                @if ($usr->can('musumba_steel_fuel_supplier_order.view'))
                                <li class=""><a href="{{ route('admin.ms-fuel-supplier-orders.index') }}"><i class="fa fa-first-order"></i>&nbsp;@lang('Commande Carburant')</a></li>
                                @endif
                                @if ($usr->can('musumba_steel_material_reception.view'))
                                <li class=""><a href="{{ route('admin.ms-material-receptions.index') }}"><i class="fa fa-shopping-basket"></i>&nbsp;@lang('Reception Materiel')</a></li>
                                @endif
                                @if ($usr->can('musumba_steel_fuel_reception.view'))
                                <li class=""><a href="{{ route('admin.ms-fuel-receptions.index') }}"><i class="fa fa-shopping-basket"></i>&nbsp;@lang('Reception Carburant')</a></li>
                                @endif

                        </ul>
                    </li>
                    @endif
                    @if ($usr->can('musumba_steel_material_stockin.create') || $usr->can('musumba_steel_material_stockin.view') ||  $usr->can('musumba_steel_material_stockin.edit') ||  $usr->can('musumba_steel_material_stockin.delete') || $usr->can('musumba_steel_material_stockout.create') || $usr->can('musumba_steel_material_stockout.view') ||  $usr->can('musumba_steel_material_stockout.edit') ||  $usr->can('musumba_steel_material_stockout.delete') ||  $usr->can('musumba_steel_fuel_stockin.view') ||  $usr->can('musumba_steel_fuel_stockout.view'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-list"></i><span>
                            @lang('messages.stockin') / @lang('messages.stockout')
                        </span></a>
                        <ul class="collapse">
                                @if($usr->can('musumba_steel_material_stockin.view'))
                                <li class=""><a href="{{ route('admin.ms-material-stockins.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Entree Materiels')</a></li>
                                @endif
                                @if($usr->can('musumba_steel_fuel_stockin.view'))
                                <li class=""><a href="{{ route('admin.ms-fuel-stockins.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Fuel Stockin')</a></li>
                                @endif
                                @if($usr->can('musumba_steel_material_stockout.view'))
                                <li class=""><a href="{{ route('admin.ms-material-stockouts.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Sortie Materiels')</a></li>
                                @endif
                                @if($usr->can('musumba_steel_fuel_stockout.view'))
                                <li class=""><a href="{{ route('admin.ms-fuel-stockouts.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('Fuel Stockout')</a></li>
                                @endif

                        </ul>
                    </li>
                    @endif
                    @if ($usr->can('musumba_steel_material_report.view') || $usr->can('musumba_steel_fuel_report.view'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-bar-chart"></i><span>
                            @lang('messages.stock_report')
                        </span></a>
                        <ul class="collapse">
                                @if ($usr->can('musumba_steel_material_report.view'))
                                <li class=""><a href="{{ route('admin.ms-material-store-report.index') }}">@lang('stock materiel ')</a></li>
                                @endif
                                @if ($usr->can('musumba_steel_fuel_report.view'))
                                <li class=""><a href="{{ route('admin.ms-fuel-report.index') }}">@lang('Mouvement Carburant')</a></li>
                                @endif
                        </ul>
                    </li>
                    @endif

                    <!-- human resource management -->
                    @if ($usr->can('hr_employe.create') || $usr->can('hr_employe.view') ||  $usr->can('hr_employe.edit') ||  $usr->can('hr_employe.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            @lang('Employes')
                        </span></a>
                        <ul class="">
                            @if ($usr->can('hr_departement.view'))
                                <li class=""><a href="{{ route('admin.hr-companies.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('Entreprises')</a></li>
                            @endif
                            @if ($usr->can('hr_departement.view'))
                                <li class=""><a href="{{ route('admin.hr-departements.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('Département')</a></li>
                            @endif
                            @if ($usr->can('hr_service.view'))
                                <li class=""><a href="{{ route('admin.hr-services.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('Services')</a></li>
                            @endif
                            @if ($usr->can('hr_fonction.view'))
                                <li class=""><a href="{{ route('admin.hr-fonctions.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('Fonctions')</a></li>
                            @endif
                            @if ($usr->can('hr_grade.view'))
                                <li class=""><a href="{{ route('admin.hr-grades.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('Grades')</a></li>
                            @endif
                            @if ($usr->can('hr_banque.view'))
                                <li class=""><a href="{{ route('admin.hr-banques.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('Banques')</a></li>
                            @endif
                            @if ($usr->can('hr_employe.view'))
                                <li class=""><a href="{{ route('admin.hr-company.select') }}"><i class="fa fa-user"></i>&nbsp;@lang('Employés')</a></li>
                            @endif
                            
                        </ul>
                    </li>
                    @endif
                    <!-- human resource management -->
                    @if ($usr->can('hr_ecole.create') || $usr->can('hr_ecole.view') ||  $usr->can('hr_filiere.view') ||  $usr->can('hr_filiere.create') || $usr->can('hr_stagiaire.create') || $usr->can('hr_stagiaire.view') ||  $usr->can('hr_stagiaire.edit') ||  $usr->can('hr_stagiaire.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            @lang('Stagiaires')
                        </span></a>
                        <ul class="">
                            @if ($usr->can('hr_ecole.view'))
                                <li class=""><a href="{{ route('admin.hr-ecoles.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('Ecoles')</a></li>
                            @endif
                            @if ($usr->can('hr_filiere.view'))
                                <li class=""><a href="{{ route('admin.hr-filieres.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('Filieres')</a></li>
                            @endif
                            @if ($usr->can('hr_stagiaire.view'))
                                <li class=""><a href="{{ route('admin.stagiare-select-by-company') }}"><i class="fa fa-user"></i>&nbsp;@lang('Stagiaires')</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    <!-- human resource management -->
                    @if ($usr->can('hr_conge.create') || $usr->can('hr_conge.view') ||  $usr->can('hr_conge.edit') ||  $usr->can('hr_conge.delete') || $usr->can('hr_conge_paye.create') || $usr->can('hr_conge_paye.view') ||  $usr->can('hr_conge_paye.edit') ||  $usr->can('hr_conge_paye.delete') || $usr->can('hr_absence.create') || $usr->can('hr_absence.view') ||  $usr->can('hr_absence.edit') ||  $usr->can('hr_absence.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            @lang('Conges')
                        </span></a>
                        <ul class="">
                            @if ($usr->can('hr_conge.view'))
                                <li class=""><a href="{{ route('admin.hr-leave-taken.select-by-company') }}"><i class="fa fa-user"></i>&nbsp;@lang('Congés')</a></li>
                            @endif
                            @if ($usr->can('hr_conge_paye.view'))
                                <li class=""><a href="{{ route('admin.hr-take-paid-leave.select-by-company') }}"><i class="fa fa-user"></i>&nbsp;@lang('Congé Payé')</a></li>
                            @endif
                            @if ($usr->can('hr_absence.view'))
                                <li class=""><a href=""><i class="fa fa-user"></i>&nbsp;@lang('Présence&amp;Absence')</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    <!-- human resource management -->
                    @if ($usr->can('hr_paiement.create') || $usr->can('hr_paiement.view') ||  $usr->can('hr_paiement.edit') ||  $usr->can('hr_paiement.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            @lang('Bulletin de paie')
                        </span></a>
                        <ul class="">
                            @if ($usr->can('hr_paiement.view'))
                                <li class=""><a href="{{ route('admin.hr-journal-paies.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('Journal de paie')</a></li>
                            @endif
                            @if ($usr->can('hr_paiement.view'))
                                <li class=""><a href="{{ route('admin.hr-paiement.selectByCompany') }}"><i class="fa fa-user"></i>&nbsp;@lang('Bulletin de paie')</a></li>
                            @endif
                            @if ($usr->can('hr_reglage.view'))
                                <li class=""><a href="{{ route('admin.hr-reglages.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('Réglages')</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    <!-- human resource management -->
                    @if ($usr->can('hr_journal_paie.create') || $usr->can('hr_journal_paie.view') ||  $usr->can('hr_journal_paie.edit') ||  $usr->can('hr_journal_paie.delete') || $usr->can('hr_journal_conge.create') || $usr->can('hr_journal_conge.view') ||  $usr->can('hr_journal_conge.edit') ||  $usr->can('hr_journal_conge.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            @lang('Les Journaux')
                        </span></a>
                        <ul class="">
                            @if ($usr->can('hr_journal_paie.view'))
                                <li class=""><a href="{{ route('admin.hr-journal-paies.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('Journal Paie')</a></li>
                            @endif
                            @if ($usr->can('hr_journal_paie.view'))
                                <li class=""><a href="{{ route('admin.hr-journal-cotisations.select-by-company') }}"><i class="fa fa-user"></i>&nbsp;@lang('Journal Cotisations')</a></li>
                            @endif
                            @if ($usr->can('hr_journal_paie.view'))
                                <li class=""><a href="{{ route('admin.hr-journal-impots.select-by-company') }}"><i class="fa fa-user"></i>&nbsp;@lang('Journal IRE')</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if ($usr->can('admin.create') || $usr->can('admin.view') ||  $usr->can('admin.edit') ||  $usr->can('admin.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            @lang('messages.users')
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.admins.create') || Route::is('admin.admins.index') || Route::is('admin.admins.edit') || Route::is('admin.admins.show') ? 'in' : '' }}">
                            
                            @if ($usr->can('admin.view'))
                                <li class="{{ Route::is('admin.admins.index')  || Route::is('admin.admins.edit') ? 'active' : '' }}"><a href="{{ route('admin.admins.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('messages.users')</a></li>
                            @endif
                            @if ($usr->can('role.view'))
                                <li class="{{ Route::is('admin.roles.index')  || Route::is('admin.roles.edit') ? 'active' : '' }}"><a href="{{ route('admin.roles.index') }}"><i class="fa fa-tasks"></i> &nbsp;@lang('messages.roles') & @lang('messages.permissions')</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if($usr->can('setting.view'))
                    <li class=""><a href="{{ route('admin.settings.index') }}"><i class="fa fa-cogs"></i><span>@lang('messages.setting')</a></li>
                    @endif
                    <!-- end musumba steel menu -->
                </ul>
            </nav>
        </div>
    </div>
</div>
