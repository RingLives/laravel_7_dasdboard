<?php

namespace App\Http\Controllers\Procedures;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MxpSaleProduct;
use DB;
class ProcedueresController extends Controller
{
    public  function __invoke(){
    }

    public static function generate_chalan_by_order($orderID,$type,$client_id){

    	$chalan_order = DB::table('mxp_sale_products as sp')
    		->join('mxp_invoice as iv','iv.id', '=','sp.invoice_id')
    		->join('mxp_product as p','p.id','=','sp.product_id')
    		->join('mxp_chart_of_acc_heads as coa', 'coa.chart_o_acc_head_id','=','sp.client_id')
    		->join('mxp_packet as pak','pak.id','=','p.packing_id')
    		->join('mxp_unit as unt','unt.id','=','pak.unit_id')

    		->select('sp.quantity','sp.price','sp.bonus','iv.invoice_code','iv.order_no','coa.acc_final_name','sp.vat','sp.total_amount_w_vat','sp.due_ammount','sp.sale_date','unt.name as unit',
    		 DB::Raw('GROUP_CONCAT(p.name,"(",pak.name,"(",pak.quantity,")", unt.name ,"(",pak.unit_quantity, ")" )as product_name'))

    		->where([
    			['iv.type',$type],
    			['iv.order_no',$orderID],
    			['coa.chart_o_acc_head_id',$client_id]
    			])
    		->groupBy('iv.id')
    		->get();

    	return $chalan_order;
    }

    public static function get_all_accounts_sub_head($grp_id,$comp_id){

    	$accounts_sub_head = DB::table('mxp_accounts_sub_heads as mash')
    		->join('mxp_accounts_heads as mah','mash.accounts_heads_id','=','mah.accounts_heads_id')

    		->select('mash.*', DB::Raw('CONCAT(mah.head_name_type,"(",mah.account_code,")")as account_head_details'))

    		->where([
    			['mash.group_id',$grp_id],
    			['mash.company_id',$comp_id],
    			['mash.is_deleted',0]
    			])
    		->orderBy('mash.accounts_sub_heads_id','DESC')
    		->paginate(15);

    	return $accounts_sub_head;
    }

    public static function get_all_acc_class($grp_id,$comp_id){

    	$all_acc_class =DB::table('mxp_acc_classes as mac')
    		->join('mxp_accounts_heads as mah','mac.accounts_heads_id','=','mah.accounts_heads_id') 
    		->join('mxp_accounts_sub_heads as mash','mash.accounts_sub_heads_id','=','mac.accounts_sub_heads_id')

    		->select('mac.*','mash.sub_head', DB::Raw('CONCAT(mah.head_name_type,"(",mah.account_code,")")as account_head_details'))

    		->where([
    			['mac.group_id',$grp_id],
    			['mac.company_id',$comp_id],
    			['mac.is_deleted',0]
    			])
    		->orderBy('mac.mxp_acc_classes_id','DESC')
    		->paginate(15);

    	return $all_acc_class;
    }

    public static function get_all_acc_sub_class($grp_id,$comp_id){
    	
    	$all_acc_sub_class = DB::table('mxp_acc_head_sub_classes as mahsc')
    		->join('mxp_acc_classes as mac','mac.mxp_acc_classes_id','=','mahsc.mxp_acc_classes_id')
    		->join('mxp_accounts_heads as mah','mah.accounts_heads_id','=','mahsc.accounts_heads_id')
    		->join('mxp_accounts_sub_heads as mash','mash.accounts_sub_heads_id','=','mahsc.accounts_sub_heads_id')

    		->select('mahsc.*','mac.head_class_name','mash.sub_head',
    		DB::Raw('CONCAT(mah.head_name_type,"(",mah.account_code,")")as account_head_details'))

    		->where([
    			['mahsc.group_id',$grp_id],
    			['mahsc.company_id',$comp_id],
    			['mahsc.is_deleted',0]
    			])
    		->orderBy('mahsc.mxp_acc_head_sub_classes_id','DESC')
    		->paginate(15);

    	return $all_acc_sub_class;
    }

    public static function get_all_lc_pro_in_stocks($grp_id,$comp_id){

    	$lc_pro_in_stocks = DB::table('mxp_lc_purchases as mlp')
    		->join('mxp_product as pr','mlp.product_id','=','pr.id')
    		->join('mxp_packet as pk','pr.packing_id','=','pk.id')
    		->join('mxp_unit as un','un.id','=','pk.unit_id')
    		->join('mxp_product_group as pg','pr.product_group_id','=','pg.id')
    		->join('mxp_chart_of_acc_heads as ca','ca.chart_o_acc_head_id','=','mlp.client_id')

    		->select('mlp.*','pg.name as product_group','ca.acc_final_name as client_details','un.name as unit',
    	 	DB::Raw('GROUP_CONCAT(pr.name,"(",pk.name,"(",pk.quantity,")",un.name,"(",pk.unit_quantity,")",")") as product_details'))

    		->where([
    			['mlp.com_group_id',$grp_id],
    			['mlp.company_id',$comp_id],
    			['mlp.is_deleted',0],
    			['mlp.stock_status',0],
    			['mlp.lc_status',1]
    			])
    		->groupBy('mlp.lc_purchase_id')
    		->orderBy('mlp.lc_purchase_id','DESC')
    		->get();

    	return $lc_pro_in_stocks;

    }

    public static function get_all_lc_purchase_products($grp_id,$comp_id){

    	$lc_purchase_products = DB::table('mxp_lc_purchases as mlp')
    		->join('mxp_product as pr','mlp.product_id','=','pr.id')
    		->join('mxp_packet as pk','pr.packing_id','=','pk.id')
    		->join('mxp_unit as un','un.id','=','pk.unit_id')
    		->join('mxp_chart_of_acc_heads as mu','mlp.client_id','=','mu.chart_o_acc_head_id')
    		->join('mxp_invoice as mi','mlp.invoice_id','=','mi.id')

    		->select('mlp.*','mu.acc_final_name as client_details','mi.invoice_code',
    			DB::Raw('GROUP_CONCAT(pr.name,"(",pk.name,"(",pk.quantity,")",un.name,"(",pk.unit_quantity,")",")") as product_details'))

    		->where([
    			['mlp.com_group_id',$grp_id],
    			['mlp.company_id',$comp_id],
    			['mlp.is_deleted',0]
    			])
    		->groupBy('mlp.lc_purchase_id')
    		->orderBy('mlp.lc_purchase_id','DESC')
    		->get();

    	return $lc_purchase_products;	
    }

    public static function get_all_lc_stocks_by_productGrpId($grp_id,$comp_id,$pro_grp_id){

    	$lc_stocks_by_productGrpId = DB::table('mxp_lc_purchases as pp')
    	->join('mxp_users as mu','pp.user_id','=','mu.user_id')
    	->join('mxp_product as mpr','pp.product_id','=','mpr.id')
    	->join('mxp_packet as pk','mpr.packing_id','=','pk.id')
    	->join('mxp_product_group as pg','mpr.product_group_id','=','pg.id')
    	->join('mxp_unit as u','u.id','=','pk.unit_id')
    	->join('mxp_stock as st','st.product_id','=','mpr.id')

    	->select('mpr.id as pro_id','mpr.name as product_name','mpr.product_code','pk.name as packet_name','pk.quantity as packet_quantity','u.name as unit_name','pk.unit_quantity','pg.name as product_group','mu.first_name as client_name','mu.address')

    	->where([
    			['pp.com_group_id',$grp_id],
    			['pp.company_id',$comp_id],
    			['mpr.product_group_id',$pro_grp_id],
    			['pp.is_deleted',0],
    			['pp.lc_status',1]
    			])
    	->whereNotNull('st.product_id')
    	->groupBy('mpr.id')
    	->get();

    	return $lc_stocks_by_productGrpId;
    }


    public static function get_all_packets($com_id,$group_id){

    	$all_packets = DB::table('mxp_packet as pk')
    		->join('mxp_unit as u','pk.unit_id','=','u.id')
    		->select('pk.*','u.name as unit_name')
    		->where([
    			['pk.company_id',$com_id],
    			['pk.com_group_id',$group_id],
    			['pk.is_deleted',0],
    			['pk.is_active',1]
    			])
    		->orderBy('pk.id','DESC')
    		->get();

    	return $all_packets;	
    }

    public static function get_all_products($grp_id,$comp_id){

    	$all_products = DB::table('mxp_product as pr') 
    		->join('mxp_packet as pk','pr.packing_id','=','pk.id')
    		->join('mxp_product_group as pg','pr.product_group_id','=','pg.id')
    		->join('mxp_unit as u','u.id','=','pk.unit_id')

    		->select('pr.*','pg.name as pord_grp_name',
    		 DB::Raw('GROUP_CONCAT(pk.name,"(",pk.quantity,") ",u.name,"(",pk.unit_quantity,")") as packet_name'))

    		->where([
    			['pr.com_group_id',$grp_id],
    			['pr.company_id',$comp_id],
    			['pr.is_deleted',0],
    			['pr.is_active',1]
    			])
    		->groupBy('pr.id')
    		->orderBy('pr.id','DESC')
    		->paginate(15);

    	return $all_products;	
    }

    public static function get_all_products_of_stock($grp_id,$comp_id){

    	$products_of_stock = DB::table('mxp_stock as st')
    		->join('mxp_product_purchase as pp','st.purchase_id','=','pp.id')
    		->join('mxp_chart_of_acc_heads as mu','pp.client_id','=','mu.chart_o_acc_head_id')
    		->join('mxp_product as pr','st.product_id','=','pr.id')
    		->join('mxp_packet as pk','pr.packing_id','=','pk.id')
    		->join('mxp_product_group as pg','pr.product_group_id','=','pg.id')
    		->join('mxp_unit as u','u.id','=','pk.unit_id')

    		->select('st.*','pp.price','mu.acc_final_name as client_name','pg.name as product_group','pr.name as product_name','pk.name as packet_name','pk.quantity as packet_quantity','u.name as unit_name','pk.unit_quantity')

    		->where([
    			['st.com_group_id',$grp_id],
    			['st.company_id',$comp_id],
    			['st.status',1],
    			['st.is_deleted',0]
    			])
    		->orderBy('st.id','DESC')
    		->paginate(15);
    		
    	return $products_of_stock;
    }

    public static function get_all_product_purchase_info($grp_id,$comp_id){

    	$product_purchase_info = DB::table('mxp_product_purchase as mpp')
    		->leftJoin('mxp_taxvat_cals as mtc','mtc.sale_purchase_id','=','mpp.id')
            ->leftJoin('mxp_product as mp','mp.id','=','mpp.product_id')
            ->leftJoin('mxp_invoice as mi','mi.id','=','mpp.invoice_id')
            ->leftJoin('mxp_companies as mc','mc.id','=','mpp.company_id')
            ->leftJoin('mxp_taxvats as mt','mt.id','=','mtc.vat_tax_id')

            ->select('mpp.id', 'mpp.price','mpp.quantity','mp.name as product_name',
                'mc.name as client_name','mi.id',
                 DB::Raw('GROUP_CONCAT(mtc.id) as txvid'),
                 DB::Raw('GROUP_CONCAT(mtc.total_amount) as total'),
                 DB::Raw('GROUP_CONCAT(mtc.calculate_amount) as calculate'),
                 DB::Raw('GROUP_CONCAT(mt.name) as txvat_name'))

            ->where([
                ['mpp.com_group_id',1],
                ['mpp.company_id',10],
                ['mpp.is_deleted',0],
                ['mpp.is_active',1],
                ['mtc.type','purchase']
                ])
            ->groupBy('mtc.sale_purchase_id')
            ->orderBy('mtc.sale_purchase_id','DESC')
            ->get();

        return $product_purchase_info;   
    }


    public static function get_all_purchase_products($grp_id,$comp_id){
    
    $purchase_products = DB::table('mxp_product_purchase as mpp')
        ->join('mxp_product as pr','mpp.product_id','=','pr.id')
        ->join('mxp_packet as pk','pr.packing_id','=','pk.id')
        ->join('mxp_unit as u','u.id','=','pk.unit_id')
        ->join('mxp_chart_of_acc_heads as mu','mpp.client_id','=','mu.chart_o_acc_head_id')
        ->join('mxp_invoice as mi','mpp.invoice_id','=','mi.id')
        ->join('mxp_taxvat_cals as mtvc', static function ($join) {
            $join->on('mtvc.invoice_id', '=', 'mpp.invoice_id');
            $join->on('mtvc.product_id', '=', 'mpp.product_id');
            $join->on('mpp.id','=','mtvc.sale_purchase_id');     
        })
        ->join('mxp_taxvats as mt','mtvc.vat_tax_id','=','mt.id')

        ->select('mpp.*','pr.name as product_name','pk.name as packet_name','pk.quantity as packet_quantity','u.name as unit_name','pk.unit_quantity','mu.acc_final_name as client_name','mi.invoice_code','mtvc.total_amount_with_vat',
            DB::Raw('GROUP_CONCAT(mtvc.calculate_amount) as new_vat_tax'),
            DB::Raw('GROUP_CONCAT(mt.name) as vat_tax_name'),
            DB::Raw('GROUP_CONCAT(mtvc.vat_tax_id) as vat_tax_id'))

        ->where([
            ['mpp.com_group_id',$grp_id],
            ['mpp.company_id',$comp_id],
            ['mpp.is_deleted',0]
        ])
        ->groupBy('mtvc.sale_purchase_id')
        ->orderBy('mtvc.sale_purchase_id','DESC')
        ->paginate(15);

        return $purchase_products;

    }

    public static function get_all_role_list_by_group_id($grp_id){

        $role_list_by_group_id = DB::table('mxp_role as r')
            ->join('mxp_companies as c','c.id','=','r.company_id')
            ->select('r.*',DB::Raw('GROUP_CONCAT(DISTINCT(c.name)) as c_name'))
            ->where('c.group_id', $grp_id)
            ->groupBy('r.cm_group_id')
            ->get();

        return $role_list_by_group_id;   
    }

    public static function get_all_sales_product($grp_id,$comp_id){

    $sales_product = DB::table('mxp_sale_products as msp')
        ->leftJoin('mxp_product as mp','mp.id','=','msp.product_id')
        ->leftJoin('mxp_invoice as mi','mi.id','=','msp.invoice_id')
        ->leftJoin('mxp_chart_of_acc_heads as mu','msp.client_id','=','mu.chart_o_acc_head_id')
        ->leftJoin('mxp_transports as mt','mt.invoice_id','=','msp.invoice_id')
        ->leftJoin('mxp_packet as mpk','mpk.id','=','mp.packing_id')
        ->leftJoin('mxp_unit as munit','munit.id','=','mpk.unit_id')
        ->leftJoin('mxp_taxvat_cals as mtvc','mtvc.invoice_id','=','msp.invoice_id')
        ->leftJoin('mxp_taxvats as mtv','mtvc.vat_tax_id','=','mtv.id')

        ->select('mp.name as product_name','mpk.name as packet_name','mpk.quantity as packet_quantity','munit.name as unit_name','mpk.unit_quantity','mu.acc_final_name as client_name','msp.quantity', 'msp.price','mi.invoice_code', 'mt.transport_name', 'msp.sale_date',
            DB::Raw('GROUP_CONCAT(mtvc.calculate_amount) as new_vat_tax'),
            DB::Raw('GROUP_CONCAT(mtv.name) as vat_tax_name'),
            DB::Raw('GROUP_CONCAT(mtvc.vat_tax_id) as vat_tax_id'))

        ->where([
            ['msp.com_group_id',$grp_id],
            ['msp.company_id',$comp_id],
            ['msp.is_deleted',0]
        ])
        ->groupBy('mtvc.sale_purchase_id')
        ->paginate(15);
            
        return $sales_product;
    }

    public static function get_all_stocks($grp_id,$comp_id){

    $all_stocks = DB::table('mxp_product_purchase as pp')
        ->join('mxp_product as mpr','pp.product_id','=','mpr.id')
        ->join('mxp_packet as pk','mpr.packing_id','=','pk.id')
        ->join('mxp_product_group as pg','mpr.product_group_id','=','pg.id')
        ->join('mxp_chart_of_acc_heads as mu','pp.client_id','=','mu.chart_o_acc_head_id')
        ->join('mxp_unit as u','u.id','=','pk.unit_id')

        ->select('pp.*','mpr.name as product_name', 'pk.name as packet_name', 'pk.quantity as packet_quantity', 'u.name as unit_name', 'pk.unit_quantity','pg.name as product_group', 'mu.acc_final_name as client_name')

        ->where([
            ['pp.com_group_id',$grp_id],
            ['pp.company_id',$comp_id],
            ['pp.is_active',1],
            ['pp.is_deleted',0],
            ['pp.stock_status',0]
        ])
        ->orderBy('pp.id','DESC')
        ->get();

        return $all_stocks;    

    }


    public static function get_all_stocks_by_productGrpId($grp_id,$comp_id,$pro_grp_id){

        $stocks_by_productGrpId =DB::table('mxp_product_purchase as pp')
        ->join('mxp_users as mu','pp.user_id','=','mu.user_id')
        ->join('mxp_product as mpr','pp.product_id','=','mpr.id')
        ->join('mxp_packet as pk','mpr.packing_id','=','pk.id')
        ->join('mxp_product_group as pg','mpr.product_group_id','=','pg.id')
        ->join('mxp_unit as u','u.id','=','pk.unit_id')
        ->join('mxp_stock as st','st.product_id','=','mpr.id')
        ->select('mpr.id as pro_id','mpr.name as product_name','mpr.product_code','pk.name as packet_name', 'pk.quantity as packet_quantity','u.name as unit_name','pk.unit_quantity','pg.name as product_group','mu.first_name as client_name','mu.address')
        ->where([
            ['pp.com_group_id',$grp_id],
            ['pp.company_id',$comp_id],
            ['pp.product_group_id',$pro_grp_id],
            ['pp.is_active',1],
            ['pp.is_deleted',0],
            ['pp.stock_status',0]
        ])
        ->whereNotNull('st.product_id')
        ->groupBy('mpr.id')
        ->get();

        return $stocks_by_productGrpId;    
 

    }

    public static function get_all_translation(){

        $all_translation = DB::table('mxp_translation_keys as tk')
            ->join('mxp_translations as tr','tr.translation_key_id','=','tk.translation_key_id')
            ->select('tr.*','tk.translation_key')
            ->get();

        return $all_translation;    
    }

    public static function get_all_translation_with_limit(){

        $translation_with_limit = DB::table('mxp_translation_keys as tk')
            ->join('mxp_translations as tr','tr.translation_key_id','=','tk.translation_key_id')
            ->join('mxp_languages as ml','ml.lan_code','=','tr.lan_code')
            ->orderBy('tk.translation_key_id','DESC')
            ->paginate(15);

        return  $translation_with_limit;   
    }

    public static function get_child_menu_list($p_parent_menu_id,$role_id,$comp_id){

        if($comp_id !=''){
            $child_menu_list = DB::table('mxp_user_role_menu as rm')
                ->join('mxp_menu as m','m.menu_id','=','rm.menu_id')
                ->select('m.*')
                ->where([
                    ['m.parent_id', $p_parent_menu_id],
                    ['rm.role_id', $role_id],
                    ['rm.company_id', $comp_id],
                    ['m.is_active', 1]
                ])
                ->orderBy('m.order_id','ASC')
                ->get();
               
             return $child_menu_list;   
        }

        else{
            $child_menu_list = DB::table('mxp_user_role_menu as rm')
                ->join('mxp_menu as m','m.menu_id','=','rm.menu_id')
                ->select('m.*')
                ->where([
                    ['rm.role_id',$role_id],
                    ['m.parent_id',$p_parent_menu_id]
                 ])
                ->orderBy('m.order_id','ASC')
                ->get();

             return $child_menu_list; 
        }

    }


    public static function get_companies_by_group_id($grp_id){

        $companies_by_group_id = DB::table('mxp_companies')
            ->select('*')
            ->where([
                    ['group_id',$grp_id],
                    ['is_active',1]
                ])
            ->get();
        return $companies_by_group_id;     
    }

    public static function get_lc_purchase_for_excel_by_date($fromdate,$todate){

        $purchase_for_excel_by_date = DB::table('mxp_lc_purchases as mlp')
            ->join('mxp_product as pr','mlp.product_id','=','pr.id')
            ->join('mxp_packet as pk','pr.packing_id','=','pk.id')
            ->join('mxp_unit as un','un.id','=','pk.unit_id')
            ->join('mxp_chart_of_acc_heads as mu','mlp.client_id','=','mu.chart_o_acc_head_id')
            ->join('mxp_invoice as mi','mlp.invoice_id','=','mi.id')

            ->select('mlp.lc_no as LcNo','mlp.purchase_date as OpenDate','mlp.lc_amount_taka as LCValue','mlp.lc_margin as Margin','mlp.total_bank_charges as BankCharges','mlp.others_cost as CustomDutyOthersCost','mlp.total_amount_with_other_cost as TotalCost','mlp.total_paid as PaidAmount','mlp.due_payment as DuePayment','mu.acc_final_name as ClientDetails',
                DB::Raw('GROUP_CONCAT(pr.name,"(",pk.name,"(",pk.quantity,")",un.name ,"(",pk.unit_quantity,")",")") as ProductDetails'))
            
            ->whereDate('mlp.purchase_date','>=', $fromdate)
            ->whereDate('mlp.purchase_date','<=', $todate)
            ->groupBy('mlp.lc_purchase_id')
            ->get();

        return  $purchase_for_excel_by_date;   

    }


   public static function get_lc_purchase_product_by_id($lc_product_id){

        $lc_purchase_product_by_id = DB::table('mxp_lc_purchases as mlp')
            ->join('mxp_product as pr','mlp.product_id','=','pr.id')
            ->join('mxp_packet as pk','pr.packing_id','=','pk.id')
            ->join('mxp_unit as un','un.id','=','pk.unit_id')
            ->join('mxp_chart_of_acc_heads as mca','mlp.client_id','=','mca.chart_o_acc_head_id')
            ->join('mxp_invoice as mi','mlp.invoice_id','=','mi.id')

            ->select('mlp.*','mca.acc_final_name as client_details','pr.product_group_id','pr.id as product_id','mi.invoice_code','mca.acc_final_name',
                 DB::Raw('GROUP_CONCAT(pr.name,"(",pk.name,"(",pk.quantity,")",un.name ,"(",pk.unit_quantity,")",")") as ProductDetails'))
            ->where('mlp.lc_purchase_id',$lc_product_id)
            ->groupBy('mlp.lc_purchase_id')
            ->get();

        return $lc_purchase_product_by_id;   
    }


    public static function get_ledgers_by_acc_head_id($acc_head_id,$fromDate,$toDate){

    $ledgers_by_acc_head_id = DB::select("select x.journal_posting_id,
        x.journal_date,
        x.particular,
        mca.acc_final_name as ledgerName,
        x.transaction_amount_debit as debit, 
        x.transaction_amount_credit as credit, 
        SUM(y.bal) openingbalance
    
        FROM
        ( 
    
       select *,transaction_amount_debit-transaction_amount_credit as bal FROM mxp_journal_posting  where account_head_id= '".$acc_head_id."'  AND journal_date >= '".$fromDate."' and journal_date <= '".$toDate."'
    
         ) x
        JOIN
        ( 
         select *,transaction_amount_debit-transaction_amount_credit as bal FROM mxp_journal_posting  where account_head_id= '".$acc_head_id."' 
        ) y
    
        ON y.journal_posting_id <= x.journal_posting_id
        JOIN mxp_chart_of_acc_heads mca on(mca.chart_o_acc_head_id = x.account_head_id)
        GROUP BY x.journal_posting_id
        ORDER BY x.journal_posting_id ASC");

    return $ledgers_by_acc_head_id;
    }

    public static function get_ledgers_by_client_id($client_id,$fromDate,$toDate){
        $ledgers_by_client_id = DB::select("select x.journal_posting_id,
        x.journal_date,
        x.particular,
        mca.acc_final_name as ledgerName,
        x.transaction_amount_debit as debit, 
        x.transaction_amount_credit as credit, 
        SUM(y.bal) openingbalance

        FROM
        ( 
            select *,transaction_amount_debit-transaction_amount_credit as bal FROM mxp_journal_posting  where client_id=client_id AND ledger_client_id='".$client_id."' AND journal_date >= '".$fromDate."' and journal_date <= '".$toDate."'
        ) x

        JOIN

        ( 
            select *,transaction_amount_debit-transaction_amount_credit as bal FROM mxp_journal_posting  where client_id='".$client_id."' AND ledger_client_id='".$client_id."'
        ) y

        ON y.journal_posting_id <= x.journal_posting_id

        JOIN mxp_chart_of_acc_heads mca on(mca.chart_o_acc_head_id = x.client_id)
        GROUP BY x.journal_posting_id
        ORDER BY x.journal_posting_id ASC");

        return $ledgers_by_client_id;
    }


    public static function get_ledger_details_journal_by_id($journal_id,$acc_head_id){

        if($acc_head_id = -1){

            $ledger_details_journal_by_id = DB::table('mxp_journal_posting as mjp')
                ->join('mxp_chart_of_acc_heads as mu','mu.chart_o_acc_head_id','=','mjp.client_id')
                ->join('mxp_product as pr','mjp.product_id','=','pr.id')
                ->join('mxp_packet as pk','pr.packing_id','=','pk.id')
                ->join('mxp_unit as un','un.id','=','pk.unit_id')

                ->select('mjp.*','mu.acc_final_name as client_details', 'mjp.account_head_id as acc_final_name',
                 DB::Raw('GROUP_CONCAT(pr.name,"(",pk.name,"(",pk.quantity,")",un.name ,"(",pk.unit_quantity,")",")") as productDetails'))

                ->where('mjp.journal_posting_id',$journal_id)
                ->get();

            return $ledger_details_journal_by_id;    
        }

        else{
            $ledger_details_journal_by_id = DB::table('mxp_journal_posting as mjp')
                ->join('mxp_chart_of_acc_heads as mu','mu.chart_o_acc_head_id','=','mjp.client_id')
                ->join('mxp_chart_of_acc_heads as mcah','mcah.chart_o_acc_head_id','=','mjp.account_head_id')
                ->join('mxp_product as pr','mjp.product_id','=','pr.id')
                ->join('mxp_packet as pk','pr.packing_id','=','pk.id')
                ->join('mxp_unit as un','un.id','=','pk.unit_id')

                ->select('mjp.*','mu.acc_final_name as client_details', 'mcah.acc_final_name',
                 DB::Raw('GROUP_CONCAT(pr.name,"(",pk.name,"(",pk.quantity,")",un.name ,"(",pk.unit_quantity,")",")") as productDetails'))

                ->where('mjp.journal_posting_id',$journal_id)
                ->get();

            return $ledger_details_journal_by_id;
        }

    }


    public static function get_local_purchase_product_by_id($lc_product_id){
    
    $local_purchase_product_by_id = DB::table('mxp_lc_purchases as mlp')
        ->join('mxp_product as pr','mlp.product_id','=','pr.id')
        ->join('mxp_packet as pk','pr.packing_id','=','pk.id')
        ->join('mxp_unit as un','un.id','=','pk.unit_id')
        ->join('mxp_users as mu','mlp.client_id','=','mu.user_id')
        ->join('mxp_invoice as mi','mlp.invoice_id','=','mi.id')
        ->join('mxp_chart_of_acc_heads as mca','mca.chart_o_acc_head_id','=','mlp.account_head_id')

        ->select('mlp.*','mu.user_id','pr.product_group_id','pr.id as product_id','mi.invoice_code','mca.acc_final_name',
           DB::Raw('GROUP_CONCAT(pr.name,"(",pk.name,"(",pk.quantity,")",un.name ,"(",pk.unit_quantity,")",")") as productDetails'),
            DB::Raw('GROUP_CONCAT(mu.first_name,"(",mu.address,")") as client_details'))

        ->where('mlp.lc_purchase_id',$lc_product_id)
        ->groupBy('mlp.lc_purchase_id')
        ->get();

        return $local_purchase_product_by_id;

    }

    public static function get_order_noBY_type($type,$company_id,$com_group_id){

        $order_noBY_type = DB::table('mxp_invoice')
            ->select('order_no')
            ->where([
                    ['type',$type],
                    ['company_id',$company_id],
                    ['com_group_id',$com_group_id],
                ])
            ->whereNotNull('order_no')
            ->groupBy('invoice_code')
            ->get();
        return $order_noBY_type;    
    }

    public static function get_permission($role_id,$route,$comp_id){

        if($comp_id !=''){
            $permission = DB::table('mxp_user_role_menu as rm')
                ->join('mxp_menu as m','m.menu_id','=','rm.menu_id')
                ->select(DB::Raw('COUNT(*) as cnt'))
                ->where([
                    ['m.route_name',$route],
                    ['rm.role_id',$role_id],
                    ['rm.company_id',$comp_id]
                ])
                ->get();
            return $permission;    
        }

        else{
             $permission = DB::table('mxp_user_role_menu as rm')
                ->join('mxp_menu as m','m.menu_id','=','rm.menu_id')
                ->select(DB::Raw('COUNT(*) as cnt'))
                ->where([
                    ['m.route_name',$route],
                    ['rm.role_id',$role_id]
                ])
                ->get();
            return $permission; 
        }
    }

    public static function get_productDetails_by_id($product_id){

        $productDetails_by_id = DB::table('mxp_product as mp')
            ->join('mxp_packet as mpk','mpk.id','=','mp.packing_id')
            ->join('mxp_unit as mu','mu.id','=','mpk.unit_id')

            ->select(DB::Raw('CONCAT(mp.name,"(",mpk.name,"(",mpk.quantity,")",mu.name,"(",mpk.unit_quantity,")",")") as product_details'))

            ->where('mp.id',$product_id)
            ->get();

        return $productDetails_by_id;    
    }


    public static function get_product_with_packet_and_unit($grp_id,$comp_id,$pro_grp_id){

        $product_with_packet_and_unit = DB::table('mxp_product as mpro')
            ->leftJoin('mxp_packet as mpac','mpac.id','=','mpro.packing_id')
            ->leftJoin('mxp_unit as munit','mpac.unit_id','=','munit.id')

            ->select('mpro.id', 'mpro.name AS pro_name','mpro.product_code','mpac.name AS pac_name', 'mpac.quantity', 'munit.name AS unit_name', 'mpac.unit_quantity')

             ->where([
                    ['mpro.com_group_id',$grp_id],
                    ['mpro.company_id',$comp_id],
                    ['mpro.product_group_id',$pro_grp_id],
                    ['mpro.is_active',1],
                    ['mpro.is_deleted',0]
                ])
            ->get();
            
        return $product_with_packet_and_unit;    
    }


    public static function get_purchase_productBy_id($purchase_product_id){

        $purchase_productBy_id = DB::table('mxp_product_purchase as mpp')
            ->join('mxp_product as pr','mpp.product_id','=','pr.id')
            ->join('mxp_packet as pk','pr.packing_id','=','pk.id')
            ->join('mxp_unit as u','u.id','=','pk.unit_id')
            ->join('mxp_chart_of_acc_heads as mu','mpp.client_id','=','mu.chart_o_acc_head_id')
            ->join('mxp_invoice as mi','mpp.invoice_id','=','mi.id')
            ->join('mxp_taxvat_cals as mtvc', static function ($join) {
                $join->on('mtvc.invoice_id', '=', 'mpp.invoice_id');
                $join->on('mtvc.product_id', '=', 'mpp.product_id');
                $join->on('mpp.id','=','mtvc.sale_purchase_id');     
            })
            ->join('mxp_taxvats as mt','mtvc.vat_tax_id','=','mt.id')

            ->select('mpp.*','pr.name as product_name','pk.name as packet_name','pk.quantity as packet_quantity','u.name as unit_name','pk.unit_quantity', 'mu.acc_final_name as client_name','mi.invoice_code',
                DB::Raw('GROUP_CONCAT(mtvc.calculate_amount) as new_vat_tax'),
                DB::Raw('GROUP_CONCAT(mt.name) as vat_tax_name'),
                DB::Raw('GROUP_CONCAT(mtvc.vat_tax_id) as vat_tax_id'))

            ->where('mpp.id',$purchase_product_id)
            ->groupBy('mtvc.sale_purchase_id')
            ->get();

        return $purchase_productBy_id;    
    }

    public static function get_roles_by_company_id($cmpny_id,$cm_grp_id){

        $roles_by_company_id = DB::table('mxp_role as rl')
            ->join('mxp_companies as cm','rl.company_id','=','cm.id')
            ->select('rl.name as roleName', 'cm.name as companyName', 'cm.id as company_id', 'rl.cm_group_id', 'rl.is_active' )

            ->where([
                    ['cm.group_id',$cmpny_id],
                    ['rl.cm_group_id',$cm_grp_id]
                ])
            ->get();

        return  $roles_by_company_id;   
    }

    public static function get_searched_trans_key($_key){

        $searched_trans_key = DB::table('mxp_translation_keys as tk')
            ->join('mxp_translations as tr','tk.translation_key_id','=','tr.translation_key_id')
            ->select('tk.translation_key_id', 'tk.is_active','tk.translation_key')
            ->distinct('tk.translation_key')
            ->where('tk.translation_key', 'LIKE', '%' . $_key . '%')
            ->get();
        return $searched_trans_key;    

    }

    public static function get_translations_by_key_id($key_id){

        $translations_by_key_id = DB::table('mxp_translations')
            ->select('translation_id', 'translation', 'lan_code')
            ->where([
                    ['translation_key_id',$key_id],
                    ['is_active',1]
                ])
            ->get();

        return $translations_by_key_id;    

    }

    public static function get_translations_by_locale($locale_code){

        $translations_by_locale = DB::table('mxp_translation_keys as tk')
            ->join('mxp_translations as tr','tr.translation_key_id','=','tk.translation_key_id')

            ->select('tr.translation','tk.translation_key')
            ->where('tr.lan_code',$locale_code)
            ->get();
        return $translations_by_locale;

    }

    public static function get_translation_by_key_id($tr_key_id){

        $translation_by_key_id = DB::table('mxp_translation_keys as tk')
            ->join('mxp_translations as tr','tr.translation_key_id','=','tk.translation_key_id')
            ->join('mxp_languages as ln','ln.lan_code','=','tr.lan_code')
            ->select('tr.translation','tk.translation_key','tk.translation_key_id','tk.is_active','ln.lan_name')
            ->where('tr.translation_key_id',$tr_key_id)
            ->get();

        return $translation_by_key_id;
    }

    // problem
    public static function get_trial_balances($fromDate,$toDate){

        
        $trial_balances = DB::table('mxp_journal_posting as jp')
            ->join('mxp_chart_of_acc_heads as ac','jp.account_head_id','=','ac.chart_o_acc_head_id')
            ->join('mxp_acc_head_sub_classes as sub','sub.mxp_acc_head_sub_classes_id','=','ac.mxp_acc_head_sub_classes_id')
            ->join('mxp_acc_classes as cls','cls.mxp_acc_classes_id','=','ac.mxp_acc_classes_id')
            ->join('mxp_accounts_sub_heads as sd','sd.accounts_sub_heads_id','=','ac.accounts_sub_heads_id')
            ->join('mxp_accounts_heads as ad','ad.accounts_heads_id','=','ac.accounts_heads_id')

            ->select('ad.head_name_type', 'ad.accounts_heads_id','ac.acc_final_name','jp.account_head_id as chart_of_acc_id','sub.head_sub_class_name', 'sub.mxp_acc_head_sub_classes_id','cls.head_class_name',    
                'cls.mxp_acc_classes_id','sd.sub_head', 'sd.accounts_sub_heads_id',
                DB::Raw('sum(jp.transaction_amount_debit-jp.transaction_amount_credit) as balance'))

            ->whereDate('jp.journal_date','>=', $fromDate)
            ->whereDate('jp.journal_date','<=', $toDate)
            ->groupBy('jp.account_head_id')
            ->orderBy('ad.accounts_heads_id')
            ->get();

        return $trial_balances;    
    }

    public static function get_user_menu_by_role($role_id,$comp_id){

        if($comp_id !=''){
            $user_menu_by_role = DB::table('mxp_user_role_menu as rm')
                ->join('mxp_menu as m','m.menu_id','=','rm.menu_id')
                ->select('m.*')
                 ->where([
                    ['rm.role_id',$role_id],
                    ['rm.company_id',$comp_id]
                ])
                ->get();
                
            return  $user_menu_by_role;    
        }
        else{
            $user_menu_by_role = DB::table('mxp_user_role_menu as rm')
                ->join('mxp_menu as m','m.menu_id','=','rm.menu_id')
                ->select('m.*')
                 ->where([
                    ['rm.role_id',$role_id]
                ])
                ->get();
            return  $user_menu_by_role;
        }
    }

}
