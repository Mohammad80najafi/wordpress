<?php


defined('ABSPATH') || exit;

// add_action('admin_menu', function () {
//     add_menu_page(
//         'کارمندان',
//         'کارمندان',
//         'manage_options',
//         'wme_employee',
//         'callback',
//         '',
//         null
//     );
// });

// function callback()
// {

//     wp_die('this is addmin menu');
// }

add_action('admin_menu', 'wme_add_menu');
function wme_add_menu()
{


    $list_hook_suffix = add_menu_page(
        esc_html__("Employees", 'webino'),
        esc_html__("Employees", 'webino'),
        'manage_options',
        'wme_employees',
        'wme_render_list'
    );

    add_action('load-' . $list_hook_suffix, 'wme_proccess_deletion');
    add_action('load-' . $list_hook_suffix, 'wme_proccess_table_data');

    add_submenu_page(
        'wme_employees',
        esc_html__('New employee', 'webino'),
        esc_html__('New employee', 'webino'),
        'manage_options',
        'wme_employees_create',
        'wme_render_form'
    );
}


function wme_proccess_table_data()
{
    require(WEBINO_MANAGE_EMPLOYEES_ADMIN_PATH . 'Employee_List_table.php');
    $GLOBALS['employee_list_table'] = new Employee_List_Table();
    $GLOBALS['employee_list_table']->prepare_items();
}

function wme_proccess_deletion()
{
    if (isset($_GET['action']) && $_GET['action'] == 'delete_employee' && isset($_GET['id'])) {
        $employee_id = absint($_GET['id']);

        if (!isset($_GET['csrf']) || !wp_verify_nonce($_GET['csrf'], 'delete_employee' . $_GET['id'])) {
            wp_die('No correct nonce');
        }

        global $wpdb;
        $table_employee = $wpdb->prefix . 'wme_employees';

        $deleted = $wpdb->delete(
            $table_employee,
            [
                'ID' => $employee_id,
            ],
            [
                '%d'
            ]
        );

        if ($deleted) {
            wp_redirect(
                admin_url('admin.php?page=wme_employees&employee_status=deleted')
            );
            exit;
        } else {
            wp_redirect(
                admin_url('admin.php?page=wme_employees&employee_status=delete_error')
            );
            exit;
        }
    }
}

function wme_render_list()
{
    include WEBINO_MANAGE_EMPLOYEES_VIEW . 'list_employees.php';
}

function wme_render_form()
{
    global $wpdb;
    $employee = false;

    if (isset($_GET['employee_id'])) {
        $employee_id = absint($_GET['employee_id']);
        wp_die($_GET['employee_id']);
        if ($employee_id) {
            $sql = $wpdb->prepare(
                "SELECT * FROM $wpdb->wme_employees WHERE ID = %d",
                $employee_id
            );

            $employee = $wpdb->get_row($sql);
        }
    }

    include WEBINO_MANAGE_EMPLOYEES_VIEW . 'form_employees.php';
}


add_action('admin_init', 'wme_form_submit');
function wme_form_submit()
{

    global $pagenow;
    if ($pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] == 'wme_employees_create') {

        if (isset($_POST['save_employee'])) {

            $employee_id     = absint($_POST['ID']);

            if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'edit_employee' . $employee_id)) {
                wp_die('nonce invalid');
            }

            if (!check_admin_referer('edit_employee' . $employee_id)) {
                wp_die('You should send data from form');
            }


            $data   = [
                'first_name'    => sanitize_text_field($_POST['first_name']),
                'last_name'     => wp_kses_post($_POST['last_name']),
                'birthdate'     => sanitize_text_field($_POST['birthdate']),
                'avatar'        => sanitize_text_field($_POST['avatar']),
                'mission'       => absint($_POST['mission']),
                'weight'        => floatval($_POST['weight']),
            ];

            global $wpdb;
            $table_employees = $wpdb->prefix . 'wme_employees';

            if ($employee_id) {

                $updated_rows = $wpdb->update(
                    $table_employees,
                    $data,
                    [
                        'ID'    => $employee_id,
                    ],
                    [
                        '%s', '%s', '%s', '%s', '%d', '%f'
                    ],
                    [
                        '%d'
                    ]
                );

                if ($updated_rows === false) {
                    wp_redirect(
                        admin_url('admin.php?page=wme_employees_create&employee_status=edited_error&employee_id=' . $employee_id)
                    );
                    exit;
                } else {
                    wp_redirect(
                        admin_url('admin.php?page=wme_employees_create&employee_status=edited&employee_id=' . $employee_id)
                    );
                    exit;
                }
            }

            $data['created_at'] = current_time('mysql');

            $inserted = $wpdb->insert(
                $table_employees,
                $data,
                [
                    '%s', '%s', '%s', '%s', '%d', '%f', '%s'
                ]
            );

            if ($inserted) {
                $employee_id = $wpdb->insert_id;
                wp_redirect(
                    admin_url('admin.php?page=wme_employees_create&employee_status=inserted&employee_id=' . $employee_id)
                );
                exit;
                //Success
            } else {
                //Error
                wp_redirect(
                    admin_url('admin.php?page=wme_employees_create&employee_status=inserted_error')
                );
                exit;
            }
        }
    }
}
