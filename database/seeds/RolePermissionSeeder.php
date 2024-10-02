<?php
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class RolePermissionSeeder.
 *
 * @see https://spatie.be/docs/laravel-permission/v5/basic-usage/multiple-guards
 *
 * @package App\Database\Seeds
 */
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // Permission List as array
        $permissions = [

            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                    'dashboard.edit',
                ]
            ],
            [
                'group_name' => 'admin',
                'permissions' => [
                    // admin Permissions
                    'admin.create',
                    'admin.view',
                    'admin.edit',
                    'admin.delete',
                ]
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    // role Permissions
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                ]
            ],
            [
                'group_name' => 'address',
                'permissions' => [
                    // address Permissions
                    'address.create',
                    'address.view',
                    'address.edit',
                    'address.delete',
                ]
            ],
             [
                'group_name' => 'setting',
                'permissions' => [
                    // setting Permissions
                    'setting.create',
                    'setting.view',
                    'setting.edit',
                    'setting.delete',
                ]
            ],
            [
                'group_name' => 'fiches',
                'permissions' => [
                    // fiches Permissions
                    'bon_entree.imprimer',
                    'bon_sortie.imprimer',
                    'fiche_reception_boisson.imprimer',
                    'fiche_reception_nourriture.imprimer',
                    'fiche_reception_material.imprimer',
                    'facture.imprimer',
                    'fiche_commande_boisson.imprimer',
                    'fiche_commande_nourriture.imprimer',
                    'fiche_commande_materiel.imprimer',
                    'fiche_requisition_boisson.imprimer',
                    'fiche_requisition_nourriture.imprimer',
                    'fiche_requisition_materiel.imprimer',
                    'fiche_transfert_boisson.imprimer',
                    'fiche_transfert_nourriture.imprimer',
                    'fiche_transfert_materiel.imprimer',
                    'fiche_stock_boisson.imprimer',
                    'fiche_stock_nourriture.imprimer',
                    'fiche_stock_materiel.imprimer',
                    'fiche_rapport_boisson.imprimer',
                    'fiche_rapport_nourriture.imprimer',
                    'fiche_rapport_materiel.imprimer',
                ]
            ],
            [
                'group_name' => 'hr_departement',
                'permissions' => [
                    // hr_departement Permissions
                    'hr_departement.create',
                    'hr_departement.view',
                    'hr_departement.edit',
                    'hr_departement.delete',
                ]
            ],
            [
                'group_name' => 'hr_service',
                'permissions' => [
                    // hr_service Permissions
                    'hr_service.create',
                    'hr_service.view',
                    'hr_service.edit',
                    'hr_service.delete',
                ]
            ],
            [
                'group_name' => 'hr_fonction',
                'permissions' => [
                    // hr_fonction Permissions
                    'hr_fonction.create',
                    'hr_fonction.view',
                    'hr_fonction.edit',
                    'hr_fonction.delete',
                ]
            ],

            [
                'group_name' => 'hr_grade',
                'permissions' => [
                    // hr_grade Permissions
                    'hr_grade.create',
                    'hr_grade.view',
                    'hr_grade.edit',
                    'hr_grade.delete',
                ]
            ],
            [
                'group_name' => 'hr_employe',
                'permissions' => [
                    // hr_employe Permissions
                    'hr_employe.create',
                    'hr_employe.view',
                    'hr_employe.edit',
                    'hr_employe.delete',
                ]
            ],
            [
                'group_name' => 'hr_banque',
                'permissions' => [
                    // hr_banque Permissions
                    'hr_banque.create',
                    'hr_banque.view',
                    'hr_banque.edit',
                    'hr_banque.delete',
                ]
            ],
            [
                'group_name' => 'hr_stagiaire',
                'permissions' => [
                    // hr_stagiaire Permissions
                    'hr_stagiaire.create',
                    'hr_stagiaire.view',
                    'hr_stagiaire.edit',
                    'hr_stagiaire.delete',
                ]
            ],
            [
                'group_name' => 'hr_ecole',
                'permissions' => [
                    // hr_ecole Permissions
                    'hr_ecole.create',
                    'hr_ecole.view',
                    'hr_ecole.edit',
                    'hr_ecole.delete',
                ]
            ],
            [
                'group_name' => 'hr_filiere',
                'permissions' => [
                    // hr_filiere Permissions
                    'hr_filiere.create',
                    'hr_filiere.view',
                    'hr_filiere.edit',
                    'hr_filiere.delete',
                ]
            ],
            [
                'group_name' => 'hr_cotation',
                'permissions' => [
                    // hr_cotation Permissions
                    'hr_cotation.create',
                    'hr_cotation.view',
                    'hr_cotation.edit',
                    'hr_cotation.delete',
                ]
            ],
            [
                'group_name' => 'hr_cotisation',
                'permissions' => [
                    // hr_cotisation Permissions
                    'hr_cotisation.create',
                    'hr_cotisation.view',
                    'hr_cotisation.edit',
                    'hr_cotisation.delete',
                ]
            ],
            [
                'group_name' => 'hr_indemnite',
                'permissions' => [
                    // hr_indemnite Permissions
                    'hr_indemnite.create',
                    'hr_indemnite.view',
                    'hr_indemnite.edit',
                    'hr_indemnite.delete',
                ]
            ],
            [
                'group_name' => 'hr_conge',
                'permissions' => [
                    // hr_conge Permissions
                    'hr_conge.create',
                    'hr_conge.view',
                    'hr_conge.edit',
                    'hr_conge.delete',
                ]
            ],
            [
                'group_name' => 'hr_conge_paye',
                'permissions' => [
                    // hr_conge_paye Permissions
                    'hr_conge_paye.create',
                    'hr_conge_paye.view',
                    'hr_conge_paye.edit',
                    'hr_conge_paye.delete',
                ]
            ],
            [
                'group_name' => 'hr_reglage',
                'permissions' => [
                    // hr_reglage Permissions
                    'hr_reglage.create',
                    'hr_reglage.view',
                    'hr_reglage.edit',
                    'hr_reglage.delete',
                ]
            ],
            [
                'group_name' => 'hr_note_interne',
                'permissions' => [
                    // hr_note_interne Permissions
                    'hr_note_interne.create',
                    'hr_note_interne.view',
                    'hr_note_interne.edit',
                    'hr_note_interne.delete',
                ]
            ],
            [
                'group_name' => 'hr_impot',
                'permissions' => [
                    // hr_impot Permissions
                    'hr_impot.create',
                    'hr_impot.view',
                    'hr_impot.edit',
                    'hr_impot.delete',
                ]
            ],
            [
                'group_name' => 'hr_prime',
                'permissions' => [
                    // hr_prime Permissions
                    'hr_prime.create',
                    'hr_prime.view',
                    'hr_prime.edit',
                    'hr_prime.delete',
                ]
            ],
            [
                'group_name' => 'hr_paiement',
                'permissions' => [
                    // hr_paiement Permissions
                    'hr_paiement.create',
                    'hr_paiement.view',
                    'hr_paiement.show',
                    'hr_paiement.edit',
                    'hr_paiement.print',
                    'hr_paiement.delete',
                ]
            ],
            [
                'group_name' => 'hr_journal_paie',
                'permissions' => [
                    // hr_journal_paie Permissions
                    'hr_journal_paie.create',
                    'hr_journal_paie.view',
                    'hr_journal_paie.cloturer',
                    'hr_journal_paie.show',
                    'hr_journal_paie.edit',
                    'hr_journal_paie.delete',
                ]
            ],
            [
                'group_name' => 'hr_journal_conge',
                'permissions' => [
                    // hr_journal_conge Permissions
                    'hr_journal_conge.create',
                    'hr_journal_conge.view',
                    'hr_journal_conge.show',
                    'hr_journal_conge.edit',
                    'hr_journal_conge.delete',
                ]
            ],
            [
                'group_name' => 'hr_journal_cotisation',
                'permissions' => [
                    // hr_journal_cotisation Permissions
                    'hr_journal_cotisation.create',
                    'hr_journal_cotisation.view',
                    'hr_journal_cotisation.show',
                    'hr_journal_cotisation.edit',
                    'hr_journal_cotisation.delete',
                ]
            ],
            [
                'group_name' => 'hr_absence',
                'permissions' => [
                    // hr_absence Permissions
                    'hr_absence.create',
                    'hr_absence.view',
                    'hr_absence.show',
                    'hr_absence.edit',
                    'hr_absence.delete',
                ]
            ],
            [
                'group_name' => 'hr_loan',
                'permissions' => [
                    // hr_loan Permissions
                    'hr_loan.create',
                    'hr_loan.view',
                    'hr_loan.show',
                    'hr_loan.edit',
                    'hr_loan.delete',
                ]
            ],
            [
                'group_name' => 'profile',
                'permissions' => [
                    // profile Permissions
                    'profile.view',
                    'profile.edit',
                ]
            ],
            [
                'group_name' => 'musumba_steel_dashboard',
                'permissions' => [
                    // musumba_steel_dashboard Permissions
                    'musumba_steel_dashboard.view',
                    'musumba_steel_dashboard.edit',
                ]
            ],
            [
                'group_name' => 'musumba_holding_data',
                'permissions' => [
                    // musumba_holding_data Permissions
                    'musumba_holding_data.view',
                    'musumba_holding_data.edit',
                ]
            ],
            [
                'group_name' => 'musumba_steel_facture',
                'permissions' => [
                    // musumba_steel_facture Permissions
                    'musumba_steel_facture.view',
                    'musumba_steel_facture.create',
                    'musumba_steel_facture.edit',
                    'musumba_steel_facture.show',
                    'musumba_steel_facture.delete',
                    'musumba_steel_facture.validate',
                    'musumba_steel_facture.confirm',
                    'musumba_steel_facture.approuve',
                    'musumba_steel_facture.send',
                    'musumba_steel_facture.reset',
                    'musumba_steel_facture.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_material',
                'permissions' => [
                    // musumba_steel_material Permissions
                    'musumba_steel_material.create',
                    'musumba_steel_material.view',
                    'musumba_steel_material.edit',
                    'musumba_steel_material.delete',
                ]
            ],
            [
                'group_name' => 'musumba_steel_material_category',
                'permissions' => [
                    // musumba_steel_material_category Permissions
                    'musumba_steel_material_category.create',
                    'musumba_steel_material_category.view',
                    'musumba_steel_material_category.edit',
                    'musumba_steel_material_category.delete',
                ]
            ],
            [
                'group_name' => 'musumba_steel_material_store',
                'permissions' => [
                    // musumba_steel_material_store Permissions
                    'musumba_steel_material_store.create',
                    'musumba_steel_material_store.view',
                    'musumba_steel_material_store.edit',
                    'musumba_steel_material_store.delete',
                ]
            ],
            [
                'group_name' => 'musumba_steel_material_reception',
                'permissions' => [
                    // musumba_steel_material_reception Permissions
                    'musumba_steel_material_reception.create',
                    'musumba_steel_material_reception.view',
                    'musumba_steel_material_reception.edit',
                    'musumba_steel_material_reception.show',
                    'musumba_steel_material_reception.delete',
                    'musumba_steel_material_reception.validate',
                    'musumba_steel_material_reception.confirm',
                    'musumba_steel_material_reception.approuve',
                    'musumba_steel_material_reception.reset',
                    'musumba_steel_material_reception.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_material_requisition',
                'permissions' => [
                    // musumba_steel_material_requisition Permissions
                    'musumba_steel_material_requisition.create',
                    'musumba_steel_material_requisition.view',
                    'musumba_steel_material_requisition.edit',
                    'musumba_steel_material_requisition.show',
                    'musumba_steel_material_requisition.delete',
                    'musumba_steel_material_requisition.validate',
                    'musumba_steel_material_requisition.confirm',
                    'musumba_steel_material_requisition.approuve',
                    'musumba_steel_material_requisition.reset',
                    'musumba_steel_material_requisition.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_material_purchase',
                'permissions' => [
                    // musumba_steel_material_purchase Permissions
                    'musumba_steel_material_purchase.create',
                    'musumba_steel_material_purchase.view',
                    'musumba_steel_material_purchase.edit',
                    'musumba_steel_material_purchase.show',
                    'musumba_steel_material_purchase.delete',
                    'musumba_steel_material_purchase.validate',
                    'musumba_steel_material_purchase.confirm',
                    'musumba_steel_material_purchase.approuve',
                    'musumba_steel_material_purchase.reset',
                    'musumba_steel_material_purchase.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_material_stockin',
                'permissions' => [
                    // musumba_steel_material_stockin Permissions
                    'musumba_steel_material_stockin.create',
                    'musumba_steel_material_stockin.view',
                    'musumba_steel_material_stockin.edit',
                    'musumba_steel_material_stockin.show',
                    'musumba_steel_material_stockin.delete',
                    'musumba_steel_material_stockin.validate',
                    'musumba_steel_material_stockin.confirm',
                    'musumba_steel_material_stockin.approuve',
                    'musumba_steel_material_stockin.reset',
                    'musumba_steel_material_stockin.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_material_stockout',
                'permissions' => [
                    // musumba_steel_material_stockout Permissions
                    'musumba_steel_material_stockout.create',
                    'musumba_steel_material_stockout.view',
                    'musumba_steel_material_stockout.edit',
                    'musumba_steel_material_stockout.show',
                    'musumba_steel_material_stockout.delete',
                    'musumba_steel_material_stockout.validate',
                    'musumba_steel_material_stockout.confirm',
                    'musumba_steel_material_stockout.approuve',
                    'musumba_steel_material_stockout.reset',
                    'musumba_steel_material_stockout.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_material_supplier_order',
                'permissions' => [
                    // musumba_steel_material_supplier_order Permissions
                    'musumba_steel_material_supplier_order.create',
                    'musumba_steel_material_supplier_order.view',
                    'musumba_steel_material_supplier_order.edit',
                    'musumba_steel_material_supplier_order.delete',
                    'musumba_steel_material_supplier_order.validate',
                    'musumba_steel_material_supplier_order.confirm',
                    'musumba_steel_material_supplier_order.approuve',
                    'musumba_steel_material_supplier_order.reset',
                    'musumba_steel_material_supplier_order.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_material_inventory',
                'permissions' => [
                    // musumba_steel_material_inventory Permissions
                    'musumba_steel_material_inventory.view',
                    'musumba_steel_material_inventory.create',
                    'musumba_steel_material_inventory.edit',
                    'musumba_steel_material_inventory.show',
                    'musumba_steel_material_inventory.delete',
                    'musumba_steel_material_inventory.validate',
                    'musumba_steel_material_inventory.reset',
                    'musumba_steel_material_inventory.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_material_supplier',
                'permissions' => [
                    // musumba_steel_material_supplier Permissions
                    'musumba_steel_material_supplier.create',
                    'musumba_steel_material_supplier.view',
                    'musumba_steel_material_supplier.edit',
                    'musumba_steel_material_supplier.delete',
                ]
            ],
            [
                'group_name' => 'musumba_steel_fuel_supplier',
                'permissions' => [
                    // musumba_steel_fuel_supplier Permissions
                    'musumba_steel_fuel_supplier.create',
                    'musumba_steel_fuel_supplier.view',
                    'musumba_steel_fuel_supplier.edit',
                    'musumba_steel_fuel_supplier.delete',
                ]
            ],
            [
                'group_name' => 'musumba_steel_car',
                'permissions' => [
                    // musumba_steel_car Permissions
                    'musumba_steel_car.create',
                    'musumba_steel_car.view',
                    'musumba_steel_car.edit',
                    'musumba_steel_car.delete',
                ]
            ],
            [
                'group_name' => 'musumba_steel_driver',
                'permissions' => [
                    // musumba_steel_driver Permissions
                    'musumba_steel_driver.create',
                    'musumba_steel_driver.view',
                    'musumba_steel_driver.edit',
                    'musumba_steel_driver.delete',
                ]
            ],
            [
                'group_name' => 'musumba_steel_driver_car',
                'permissions' => [
                    // musumba_steel_driver_car Permissions
                    'musumba_steel_driver_car.create',
                    'musumba_steel_driver_car.view',
                    'musumba_steel_driver_car.edit',
                    'musumba_steel_driver_car.delete',
                ]
            ],
            [
                'group_name' => 'musumba_steel_fuel',
                'permissions' => [
                    // musumba_steel_fuel Permissions
                    'musumba_steel_fuel.create',
                    'musumba_steel_fuel.view',
                    'musumba_steel_fuel.edit',
                    'musumba_steel_fuel.delete',
                ]
            ],
            [
                'group_name' => 'musumba_steel_fuel_pump',
                'permissions' => [
                    // musumba_steel_fuel_pump Permissions
                    'musumba_steel_fuel_pump.create',
                    'musumba_steel_fuel_pump.view',
                    'musumba_steel_fuel_pump.edit',
                    'musumba_steel_fuel_pump.delete',
                ]
            ],
            [
                'group_name' => 'musumba_steel_index_pump',
                'permissions' => [
                    // musumba_steel_index_pump Permissions
                    'musumba_steel_index_pump.create',
                    'musumba_steel_index_pump.view',
                    'musumba_steel_index_pump.edit',
                    'musumba_steel_index_pump.delete',
                ]
            ],
            [
                'group_name' => 'musumba_steel_fuel_reception',
                'permissions' => [
                    // musumba_steel_fuel_reception Permissions
                    'musumba_steel_fuel_reception.create',
                    'musumba_steel_fuel_reception.view',
                    'musumba_steel_fuel_reception.edit',
                    'musumba_steel_fuel_reception.show',
                    'musumba_steel_fuel_reception.delete',
                    'musumba_steel_fuel_reception.validate',
                    'musumba_steel_fuel_reception.confirm',
                    'musumba_steel_fuel_reception.approuve',
                    'musumba_steel_fuel_reception.reset',
                    'musumba_steel_fuel_reception.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_fuel_requisition',
                'permissions' => [
                    // musumba_steel_fuel_requisition Permissions
                    'musumba_steel_fuel_requisition.create',
                    'musumba_steel_fuel_requisition.view',
                    'musumba_steel_fuel_requisition.edit',
                    'musumba_steel_fuel_requisition.show',
                    'musumba_steel_fuel_requisition.delete',
                    'musumba_steel_fuel_requisition.validate',
                    'musumba_steel_fuel_requisition.confirm',
                    'musumba_steel_fuel_requisition.approuve',
                    'musumba_steel_fuel_requisition.reset',
                    'musumba_steel_fuel_requisition.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_fuel_purchase',
                'permissions' => [
                    // musumba_steel_fuel_purchase Permissions
                    'musumba_steel_fuel_purchase.create',
                    'musumba_steel_fuel_purchase.view',
                    'musumba_steel_fuel_purchase.edit',
                    'musumba_steel_fuel_purchase.show',
                    'musumba_steel_fuel_purchase.delete',
                    'musumba_steel_fuel_purchase.validate',
                    'musumba_steel_fuel_purchase.confirm',
                    'musumba_steel_fuel_purchase.approuve',
                    'musumba_steel_fuel_purchase.reset',
                    'musumba_steel_fuel_purchase.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_fuel_stockin',
                'permissions' => [
                    // musumba_steel_fuel_stockin Permissions
                    'musumba_steel_fuel_stockin.create',
                    'musumba_steel_fuel_stockin.view',
                    'musumba_steel_fuel_stockin.edit',
                    'musumba_steel_fuel_stockin.show',
                    'musumba_steel_fuel_stockin.delete',
                    'musumba_steel_fuel_stockin.validate',
                    'musumba_steel_fuel_stockin.confirm',
                    'musumba_steel_fuel_stockin.approuve',
                    'musumba_steel_fuel_stockin.reset',
                    'musumba_steel_fuel_stockin.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_fuel_stockout',
                'permissions' => [
                    // musumba_steel_fuel_stockout Permissions
                    'musumba_steel_fuel_stockout.create',
                    'musumba_steel_fuel_stockout.view',
                    'musumba_steel_fuel_stockout.edit',
                    'musumba_steel_fuel_stockout.show',
                    'musumba_steel_fuel_stockout.delete',
                    'musumba_steel_fuel_stockout.validate',
                    'musumba_steel_fuel_stockout.confirm',
                    'musumba_steel_fuel_stockout.approuve',
                    'musumba_steel_fuel_stockout.reset',
                    'musumba_steel_fuel_stockout.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_fuel_supplier_order',
                'permissions' => [
                    // musumba_steel_fuel_supplier_order Permissions
                    'musumba_steel_fuel_supplier_order.create',
                    'musumba_steel_fuel_supplier_order.view',
                    'musumba_steel_fuel_supplier_order.edit',
                    'musumba_steel_fuel_supplier_order.delete',
                    'musumba_steel_fuel_supplier_order.validate',
                    'musumba_steel_fuel_supplier_order.confirm',
                    'musumba_steel_fuel_supplier_order.approuve',
                    'musumba_steel_fuel_supplier_order.reset',
                    'musumba_steel_fuel_supplier_order.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_fuel_inventory',
                'permissions' => [
                    // musumba_steel_fuel_inventory Permissions
                    'musumba_steel_fuel_inventory.view',
                    'musumba_steel_fuel_inventory.create',
                    'musumba_steel_fuel_inventory.edit',
                    'musumba_steel_fuel_inventory.show',
                    'musumba_steel_fuel_inventory.delete',
                    'musumba_steel_fuel_inventory.validate',
                    'musumba_steel_fuel_inventory.reset',
                    'musumba_steel_fuel_inventory.reject',
                ]
            ],
            [
                'group_name' => 'musumba_steel_fuel_report',
                'permissions' => [
                    'musumba_steel_fuel_report.view',
                ]
            ],
            [
                'group_name' => 'musumba_steel_material_report',
                'permissions' => [
                    'musumba_steel_material_report.view',
                ]
            ],
        ];


        // Do same for the admin guard for tutorial purposes
        $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);

        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup, 'guard_name' => 'admin']);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }

        // Assign super admin role permission to superadmin user
        $admin = Admin::where('username', 'superadmin')->first();
        if ($admin) {
            $admin->assignRole($roleSuperAdmin);
        }
    }
}
