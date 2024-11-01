<?php
/*
Plugin Name: sprInvoice
Plugin Script: sprinvoice.php
Plugin URI: http://sprresponsive.com/invoice-generator-wordpress/
Description: A simple invoice generator for WordPress.
Version: 0.1
Author: Topher Wilson
Author URI: http://sprresponsive.com
Template by: http://sprresponsive.com
License: GPLv2 or later

*/


class sprInvoiceSettings
{
    private $options;

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }


    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'sprInvoice Settings', 
            'sprInvoice Settings', 
            'manage_options', 
            'spr-invoice-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    public function create_admin_page()
    {

        $this->options = get_option( 'spr_options' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>sprInvoice Settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'spr_option_group' );   
                do_settings_sections( 'spr-invoice-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    public function print_section_info()
    {
        print 'Add your company / invoice information below.';
    }

    public function page_init()
    {        
        register_setting(
            'spr_option_group', 
            'spr_options', 
            array( $this, 'sanitize' ) 
        );

        add_settings_section(
            'spr_settings', 
            '', // empty title for now, maybe if this grows
            array( $this, 'print_section_info' ), 
            'spr-invoice-admin' 
        );   

        add_settings_field(
            'company_name', 
            'Company Name', 
            array( $this, 'CompanyCallback' ), 
            'spr-invoice-admin', 
            'spr_settings'
        );   

        add_settings_field(
            'company_tagline', 
            'Company Tagline', 
            array( $this, 'TagCallback' ), 
            'spr-invoice-admin', 
            'spr_settings'
        );

        add_settings_field(
            'company_url', 
            'Company Website Address', 
            array( $this, 'WebCallback' ), 
            'spr-invoice-admin', 
            'spr_settings'
        );

        add_settings_field(
            'contact_name', 
            'Contact Name', 
            array( $this, 'ContactCallback' ), 
            'spr-invoice-admin', 
            'spr_settings'
        );      

        add_settings_field(
            'contact_email', 
            'Contact Email Address', 
            array( $this, 'EmailCallback' ), 
            'spr-invoice-admin', 
            'spr_settings'
        );

        add_settings_field(
            'address_line1', 
            'Address Line 1', 
            array( $this, 'Address1Callback' ), 
            'spr-invoice-admin', 
            'spr_settings'
        );

        add_settings_field(
            'address_line2', 
            'Address Line 2', 
            array( $this, 'Address2Callback' ), 
            'spr-invoice-admin', 
            'spr_settings'
        );

        add_settings_field(
            'company_phone', 
            'Contact Phone Number', 
            array( $this, 'PhoneCallback' ), 
            'spr-invoice-admin', 
            'spr_settings'
        );

        add_settings_field(
            'sales_tax', 
            'Sales Tax Rate as % <br /><small>(leave blank if none)</small>', 
            array( $this, 'TaxCallback' ), 
            'spr-invoice-admin', 
            'spr_settings'
        );
   
    }

    public function sanitize( $input )
    {
        $new_input = array();

        $st = 'company';
        if( isset( $input[$st] ) )
            $new_input[$st] = sanitize_text_field( $input[$st] );

        $st = 'tag';
        if( isset( $input[$st] ) )
            $new_input[$st] = sanitize_text_field( $input[$st] );

        $st = 'web';
        if( isset( $input[$st] ) )
            $new_input[$st] = sanitize_text_field( $input[$st] );

        $st = 'contact';
        if( isset( $input[$st] ) )
            $new_input[$st] = sanitize_text_field( $input[$st] );

        $st = 'email';
        if( isset( $input[$st] ) )
            $new_input[$st] = sanitize_text_field( $input[$st] );

        $st = 'address1';
        if( isset( $input[$st] ) )
            $new_input[$st] = sanitize_text_field( $input[$st] );

        $st = 'address2';
        if( isset( $input[$st] ) )
            $new_input[$st] = sanitize_text_field( $input[$st] );

        $st = 'phone';
        if( isset( $input[$st] ) )
            $new_input[$st] = sanitize_text_field( $input[$st] );

        $st = 'tax';
        if( isset( $input[$st] ) )
            $new_input[$st] = sanitize_text_field( $input[$st] );

        return $new_input;
    }

    public function CompanyCallback(){
        $ft = 'company';
        printf(
            '<input type="text" id="' . $ft . '" name="spr_options[' . $ft . ']" value="%s" />',
            isset( $this->options[$ft] ) ? esc_attr( $this->options[$ft]) : ''
        );
    }

    public function TagCallback(){
        $ft = 'tag';
        printf(
            '<input style="width:400px" type="text" id="' . $ft . '" name="spr_options[' . $ft . ']" value="%s" />',
            isset( $this->options[$ft] ) ? esc_attr( $this->options[$ft]) : ''
        );
    }

    public function WebCallback(){
        $ft = 'web';
        printf(
            '<input style="width:300px" type="text" id="' . $ft . '" name="spr_options[' . $ft . ']" value="%s" />',
            isset( $this->options[$ft] ) ? esc_attr( $this->options[$ft]) : ''
        );
    }

    public function ContactCallback(){
        $ft = 'contact';
        printf(
            '<input style="width:200px" type="text" id="' . $ft . '" name="spr_options[' . $ft . ']" value="%s" />',
            isset( $this->options[$ft] ) ? esc_attr( $this->options[$ft]) : ''
        );
    }

    public function EmailCallback(){
        $ft = 'email';
        printf(
            '<input style="width:250px" type="text" id="' . $ft . '" name="spr_options[' . $ft . ']" value="%s" />',
            isset( $this->options[$ft] ) ? esc_attr( $this->options[$ft]) : ''
        );
    }

    public function Address1Callback(){
        $ft = 'address1';
        printf(
            '<input style="width:300px" type="text" id="' . $ft . '" name="spr_options[' . $ft . ']" value="%s" />',
            isset( $this->options[$ft] ) ? esc_attr( $this->options[$ft]) : ''
        );
    }

    public function Address2Callback(){
        $ft = 'address2';
        printf(
            '<input style="width:300px" type="text" id="' . $ft . '" name="spr_options[' . $ft . ']" value="%s" />',
            isset( $this->options[$ft] ) ? esc_attr( $this->options[$ft]) : ''
        );
    }

    public function PhoneCallback(){
        $ft = 'phone';
        printf(
            '<input style="width:220px" type="text" id="' . $ft . '" name="spr_options[' . $ft . ']" value="%s" />',
            isset( $this->options[$ft] ) ? esc_attr( $this->options[$ft]) : ''
        );
    }

    public function TaxCallback(){
        $ft = 'tax';
        printf(
            '<input style="width:50px" type="text" id="' . $ft . '" name="spr_options[' . $ft . ']" value="%s" />',
            isset( $this->options[$ft] ) ? esc_attr( $this->options[$ft]) : ''
        );
    }

}

if(is_admin()){
     $sprInvoiceSettings = new sprInvoiceSettings();
 }


// invoice post type
function InvoicePostType() {
    $args = array(
    'public' => true,
    'capability_type' => 'post',
    'query_var' => true,
    'supports' => array(
        'title',
        'editor' => true,
        'excerpt' => false,
        'trackbacks' => false,
        'custom-fields' => true,
        'comments' => false,
        'revisions' => false,
        'thumbnail' => false,
        'author' => false,
        'page-attributes',
    ),
    'labels' => array(
        'name' => 'Invoice',
        'singular_name' => 'Invoice',
        'plural_name' => 'Invoices',
    )
);
    register_post_type( 'invoice', $args );
}
add_action( 'init', 'InvoicePostType' );



// invoice meta boxes 
/**
 * Adds a meta box to the post editing screen
 */

function SprCallback_001(){
    global $post; ?>    
    <table width='100%'>
    <tr>
        <?php $tk = 'spr_meta_invoice_status'; ?>
        <td style='font-size: 13px;'><label>Invoice Status</label></td>
        <td><?php  $tkv = get_post_meta($post->ID, $tk, true );?>
            <div>
                <input type='radio' name='<?php echo $tk; ?>' value='unpaid' <?php if($tkv == 'unpaid'){echo 'checked'; }; ?>><span style='font-size: 13px;'>Unpaid</span> / 
                <input type='radio' name='<?php echo $tk; ?>' value='paid' <?php if($tkv == 'paid'){echo 'checked'; }; ?>><span style='font-size: 13px;'>Paid</span>
            </div>
        </td>
    </tr>
    <tr>
        <?php $tk = 'spr_meta_invoice_num'; ?>
        <td style='font-size: 13px;'><label>Invoice Number</label></td>
        <td><input type="text" name="<?php echo $tk; ?>" value="<?php  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){echo $tkv; };?>" /></td>
    </tr>
    <tr>
        <?php $tk = 'spr_meta_invoice_date'; ?>
        <td style='font-size: 13px;'><label>Invoice Date</label></td>
        <td><input type="text" name="<?php echo $tk; ?>" value="<?php  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){echo $tkv; };?>" /></td>
    </tr>
    <tr>
        <?php $tk = 'spr_meta_invoice_due'; ?>
        <td style='font-size: 13px;'><label>Invoice Due</label></td>
        <td><input type="text" name="<?php echo $tk; ?>" value="<?php  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){echo $tkv; };?>" /></td>
    </tr>
    <tr>
        <?php $tk = 'spr_meta_invoice_currency'; ?>
        <td style='font-size: 13px;'><label>Currency</label></td>
        <td><input type="text" name="<?php echo $tk; ?>" value="<?php  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){echo $tkv; } else echo 'USD';?>" /></td>
    </tr>
    </table>

<?php }
function SprCallback_002(){
    global $post;?>
    <table width='100%'>
    <tr>
        <?php $tk = 'spr_meta_name'; ?>
        <td style='font-size: 13px;'><label>Contact Name</label></td>
        <td><input style='width: 80%;' type="text" name="<?php echo $tk; ?>" value="<?php  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){echo $tkv; };?>" /></td>
    </tr>

    <tr>
        <?php $tk = 'spr_meta_email'; ?>
        <td style='font-size: 13px;'><label>Contact Email</label></td>
        <td><input style='width: 80%;' type="text" name="<?php echo $tk; ?>" value="<?php  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){echo $tkv; };?>" /></td>
    </tr>

    <tr>
        <?php $tk = 'spr_meta_company'; ?>
        <td style='font-size: 13px;'><label>Company Name</label></td>
        <td><input style='width: 70%;' type="text" name="<?php echo $tk; ?>" value="<?php  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){echo $tkv; };?>" /></td>
    </tr>

    <tr>
        <?php $tk = 'spr_meta_address_1'; ?>
        <td style='font-size: 13px;'><label>Address Line 1</label></td>
        <td><input style='width: 80%;' type="text" name="<?php echo $tk; ?>" value="<?php  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){echo $tkv; };?>" /></td>
    </tr>

    <tr>
        <?php $tk = 'spr_meta_address_2'; ?>
        <td style='font-size: 13px;'><label>Address Line 2</label></td>
        <td><input style='width: 80%;' type="text" name="<?php echo $tk; ?>" value="<?php  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){echo $tkv; };?>" /></td>
    </tr>

    <tr>
        <?php $tk = 'spr_meta_phone'; ?>
        <td style='font-size: 13px;'><label>Phone</label></td>
        <td><input style='width: 60%;' type="text" name="<?php echo $tk; ?>" value="<?php  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){echo $tkv; };?>" /></td>
    </tr>
    </table>
 
    <?php }

function SprCallback_003(){ 
    global $post;
    $invoiceRows = get_post_meta($post->ID, 'invoice_rows', true);

    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#new-row').click(function(){
            var theRow = $('.default-row').clone(true);
            theRow.removeClass('default-row');
            theRow.addClass('invoice-row');
            //$('.default-row td input').val();
            theRow.insertAfter('#invoice-items tbody tr:last-of-type');
            theRow.css('display', '');
        });

        $('.remove-row').click(function(){
            $(this).parents('tr').remove();
        });
    });

    </script>

    <table id='invoice-items' width='100%' style='text-align: left; font-size: 12px'>
    <thead width='100%'>
        <tr>
            <th>Name</th>
            <th>Count</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>

    <tbody width='100%'>


        <tr class='default-row' style='display: none'><!-- default row -->
            <td style='width: 70% !important;'><input style='width: 100%' type='text' value='' name='rowname[]' placeholder='Item Name' /></td>
            <td style='width: 10% !important;'><input type='text' value='' name='rowcount[]' placeholder='Item Count' /></td>
            <td style='width: 10% !important;'><input type='text' value='' name='rowcost[]' placeholder='Item Cost' /></td>
            <td style='width: 10% !important;'><a href='#deleterow' class='remove-row' style='display: inline-block; padding: 0 4px; color: #fff; background: red;'>X</a></td>
        </tr>

        <?php if($invoiceRows){
            foreach($invoiceRows as $invoiceRow){?>
            <tr class='existing-row'>
                <td style='width: 70% !important;'><input style='width: 100%' type='text' value='<?php if($invoiceRow['rowItemNames'] != '') echo esc_attr( $invoiceRow['rowItemNames'] ); ?>' name='rowname[]'/></td>
                <td><input type='text' value='<?php if($invoiceRow['rowItemCounts'] != '') echo esc_attr( $invoiceRow['rowItemCounts'] ); ?>' name='rowcount[]'/></td>
                <td><input type='text' value='<?php if($invoiceRow['rowItemCosts'] != '') echo esc_attr( $invoiceRow['rowItemCosts'] ); ?>' name='rowcost[]' /></td>
                <td><a href='#deleterow' class='remove-row' style='display: inline-block; padding: 0 4px; color: #fff; background: red;'>X</a></td>
            </tr>
            <?php }; ?>
        <?php }; ?>

        

    </tbody>

    <tfoot width='100%'>
        <tr>
            <td style='width: 70% !important;'><a href='#addrow' id='new-row'>Add Row</a></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>
    </table>
<?php }

function SprCallback_004(){ 
    global $post;?>    
    <table width='100%'>
     <tr>
        <?php $tk = 'spr_meta_notes'; ?>
        <td style='font-size: 13px;'>
            <label>Notes</label><br />
            <textarea style='width: 100%' rows='8' name='<?php echo $tk; ?>'><?php  $tkv = get_post_meta($post->ID, $tk, true ); if($tkv){echo $tkv; };?></textarea>
        </td>
    </tr>
    </table>

<?php }

function SprMeta(){
    add_meta_box( 'sprMetaID_001', 'Invoice Meta', 'SprCallback_001', 'invoice', 'side' );
    add_meta_box( 'sprMetaID_002', 'Invoice Receiver', 'SprCallback_002', 'invoice' );
    add_meta_box( 'sprMetaID_003', 'Invoice Items', 'SprCallback_003', 'invoice' );
    add_meta_box( 'sprMetaID_004', 'Invoice Notes', 'SprCallback_004', 'invoice' );

    wp_nonce_field( basename( __FILE__ ), 'sprNonce' );
}
add_action( 'add_meta_boxes', 'SprMeta' );


// save meta boxes
function SprMetaSave( $post_id ) {
 
    // verify savability (it's a word, you like it)
    $autosave = wp_is_post_autosave( $post_id );
    $revision = wp_is_post_revision( $post_id );
    $nonce_valid = ( isset( $_POST[ 'sprNonce' ] ) && wp_verify_nonce( $_POST[ 'sprNonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    if ( $autosave || $revision || !$nonce_valid ) {
        return;
    }

    // seems fine, let's save the easy ones
    //box 001
    $tm = 'spr_meta_invoice_status';
    if( isset( $_POST[ $tm ] ) ) {
        update_post_meta( $post_id, $tm, sanitize_text_field( $_POST[ $tm ] ) );
    }
    $tm = 'spr_meta_invoice_num';
    if( isset( $_POST[ $tm ] ) ) {
        update_post_meta( $post_id, $tm, sanitize_text_field( $_POST[ $tm ] ) );
    }
    $tm = 'spr_meta_invoice_date';
    if( isset( $_POST[ $tm ] ) ) {
        update_post_meta( $post_id, $tm, sanitize_text_field( $_POST[ $tm ] ) );
    }
    $tm = 'spr_meta_invoice_due';
    if( isset( $_POST[ $tm ] ) ) {
        update_post_meta( $post_id, $tm, sanitize_text_field( $_POST[ $tm ] ) );
    }

    // box 002
    $tm = 'spr_meta_name';
    if( isset( $_POST[ $tm ] ) ) {
        update_post_meta( $post_id, $tm, sanitize_text_field( $_POST[ $tm ] ) );
    }
    $tm = 'spr_meta_email';
    if( isset( $_POST ) ) {
        update_post_meta( $post_id, $tm, sanitize_text_field( $_POST[ $tm ] ) );
    }
    $tm = 'spr_meta_company';
    if( isset( $_POST[ $tm ] ) ) {
        update_post_meta( $post_id, $tm, sanitize_text_field( $_POST[ $tm ] ) );
    }
    $tm = 'spr_meta_address_1';
    if( isset( $_POST ) ) {
        update_post_meta( $post_id, $tm, sanitize_text_field( $_POST[ $tm ] ) );
    }
    $tm = 'spr_meta_address_2';
    if( isset( $_POST[ $tm ] ) ) {
        update_post_meta( $post_id, $tm, sanitize_text_field( $_POST[ $tm ] ) );
    }
    $tm = 'spr_meta_phone';
    if( isset( $_POST[ $tm ] ) ) {
        update_post_meta( $post_id, $tm, sanitize_text_field( $_POST[ $tm ] ) );
    }

    // box 004
    $tm = 'spr_meta_notes';
    if( isset( $_POST[ $tm ] ) ) {
        update_post_meta( $post_id, $tm, $_POST[ $tm ] );
    }

    // now let's save the harder ones
    $rowItemNames = $_POST['rowname'];
    $rowItemCounts = $_POST['rowcount'];
    $rowItemCosts = $_POST['rowcost'];

    $oldRows = get_post_meta($post_id, 'invoice_rows', true);
    $newRows = array();

    $rowCount = count($rowItemNames);
 
    for ( $i = 1; $i < $rowCount; $i++ ) {
        if($rowItemNames != ''){
            $newRows[$i]['rowItemNames'] = stripslashes(strip_tags($rowItemNames[$i]));
            $newRows[$i]['rowItemCounts'] = stripslashes(strip_tags($rowItemCounts[$i]));
            $newRows[$i]['rowItemCosts'] = stripslashes(strip_tags($rowItemCosts[$i]));
        }
    }

    if($newRows != $oldRows && !empty($newRows)){
        update_post_meta($post_id, 'invoice_rows', $newRows);
    } else if(empty($newRows) && !empty($oldRows)){
        delete_post_meta($post_id, 'invoice_rows', $oldRows);
    };

}
add_action( 'save_post', 'SprMetaSave' );


// show correct template
function get_custom_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'invoice') {
          $single_template = dirname( __FILE__ ) . '/invoice-template.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'get_custom_post_type_template' );