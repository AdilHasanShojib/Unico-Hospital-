<?php

namespace App\Http\Controllers;

use App\Datatables\DataTableClass;
use App\Library\Template;
use App\Http\Controllers\Controller;
use App\Traits\LookupData;
use App\Http\Requests\ServiceUnitRequest;
use App\Traits\DatatablesLoader;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository as Repo;
use Auth;
use DB;
use App\Models\ServiceUnit;
use App\Http\Requests\GrantSuRequest;
use App\Models\GrantSU;
use Carbon\Carbon;
use Session;

class SurgicalChecklistController extends Controller
{



    public function create()
{
    $admited_pat_info = DB::table('IPD_SAFTYCHECKLIST')
        ->where('SAFTYCHECKLIST_NO_PK', 1)
        ->first();

    //dd($admited_pat_info);

    if (!$admited_pat_info) {
        // Provide default empty object to avoid errors in blade
        $admited_pat_info = (object) [];
    }

    $pat_info = DB::table('IPD_SAFTYCHECKLIST')
        ->select(
            DB::raw('FNC_PERSONNAME(ANES_PERSON_NO_FK) AS anesthetist_name'),
            DB::raw('FNC_PERSONNAME(VERIFIED_BY_PERSON_NO_FK) AS verified_nurse'),
            DB::raw('FNC_PERSONNAME(NURSE_PERSON_N0_FK) AS nurse_name'),
            DB::raw('FNC_PERSONNAME(NURSE_PERSON_NO) AS circulating_nurse'),
            DB::raw('FNC_PERSONNAME(SCRUB_NURSE_PERSON_NO_FK) AS scrub_nurse'),
            DB::raw('FNC_PERSONNAME(ANES_SIGN_OUT_PERSON_NO_FK) AS anesthetist'),
            DB::raw('FNC_PERSONNAME(SURGEON_PERSON_NO_FK) AS surgeon')
        )
        ->where('SAFTYCHECKLIST_NO_PK', 1)
        ->first();

    if (!$pat_info) {
        // Provide default empty object to avoid errors in blade
        $pat_info = (object) [
            'anesthetist_name' => '',
            'verified_nurse' => '',
            'nurse_name' => '',
            'circulating_nurse' => '',
            'scrub_nurse' => '',
            'anesthetist' => '',
            'surgeon' => ''
        ];
    }

    return Template::loadview('admin.settings.surgical_checklist.surgical_checklist_form', [
        'admited_pat_info' => $admited_pat_info,
        'pat_info' => $pat_info
    ]);
}


    public function store(Request $request)
    {
        //dd($request->all());
        $id = $request->saftychecklist_no_pk;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        //dd($id);


        $anes_date = null;
        $timeInput = $request->input('anes_date'); // Format: HH:mm
        if (!empty($timeInput)) {
            $anes_date = Carbon::now(); // or new DateTime('now');
            $timeInput = explode(":", $timeInput);
            $timeInput = $timeInput[0] . ':' . $timeInput[1];
            $anes_date = Carbon::createFromFormat('Y-m-d H:i', $anes_date->format('Y-m-d') . ' ' . $timeInput);
        }

        $antibiotic_time = null;
        $timeInput = $request->input('antibiotic_time'); // Format: HH:mm
        if (!empty($timeInput)) {
            $antibiotic_time = Carbon::now(); // or new DateTime('now');
            $timeInput = explode(":", $timeInput);
            $timeInput = $timeInput[0] . ':' . $timeInput[1];
            $antibiotic_time = Carbon::createFromFormat('Y-m-d H:i', $antibiotic_time->format('Y-m-d') . ' ' . $timeInput);
        }


        $incision_time = null;
        $timeInput = $request->input('incision_time'); // Format: HH:mm
        if (!empty($timeInput)) {
            $incision_time = Carbon::now(); // or new DateTime('now');
            $timeInput = explode(":", $timeInput);
            $timeInput = $timeInput[0] . ':' . $timeInput[1];
            $incision_time = Carbon::createFromFormat('Y-m-d H:i', $incision_time->format('Y-m-d') . ' ' . $timeInput);
        }


        $end_anes_time = null;
        $timeInput = $request->input('end_anes_time'); // Format: HH:mm
        if (!empty($timeInput)) {
            $end_anes_time = Carbon::now(); // or new DateTime('now');
            $timeInput = explode(":", $timeInput);
            $timeInput = $timeInput[0] . ':' . $timeInput[1];
            $end_anes_time = Carbon::createFromFormat('Y-m-d H:i', $end_anes_time->format('Y-m-d') . ' ' . $timeInput);
        }

        $end_anes_surgery = null;
        $timeInput = $request->input('end_anes_surgery'); // Format: HH:mm
        if (!empty($timeInput)) {
            $end_anes_surgery = Carbon::now(); // or new DateTime('now');
            $timeInput = explode(":", $timeInput);
            $timeInput = $timeInput[0] . ':' . $timeInput[1];
            $end_anes_surgery = Carbon::createFromFormat('Y-m-d H:i', $end_anes_surgery->format('Y-m-d') . ' ' . $timeInput);
        }


        $sign_in_date = null;
        $timeInput = $request->input('sign_in_date'); // Format: HH:mm
        if (!empty($timeInput)) {
            $sign_in_date = Carbon::now(); // or new DateTime('now');
            $timeInput = explode(":", $timeInput);
            $timeInput = $timeInput[0] . ':' . $timeInput[1];
            $sign_in_date = Carbon::createFromFormat('Y-m-d H:i', $sign_in_date->format('Y-m-d') . ' ' . $timeInput);
        }


        $time_out_date = null;
        $timeInput = $request->input('time_out_date'); // Format: HH:mm
        if (!empty($timeInput)) {
            $time_out_date = Carbon::now(); // or new DateTime('now');
            $timeInput = explode(":", $timeInput);
            $timeInput = $timeInput[0] . ':' . $timeInput[1];
            $time_out_date = Carbon::createFromFormat('Y-m-d H:i', $time_out_date->format('Y-m-d') . ' ' . $timeInput);
        }



        $sign_out = null;
        $timeInput = $request->input('sign_out'); // Format: HH:mm
        if (!empty($timeInput)) {
            $sign_out = Carbon::now(); // or new DateTime('now');
            $timeInput = explode(":", $timeInput);
            $timeInput = $timeInput[0] . ':' . $timeInput[1];
            $sign_out = Carbon::createFromFormat('Y-m-d H:i', $sign_out->format('Y-m-d') . ' ' . $timeInput);
        }




        DB::beginTransaction();
        // try {


        $data = [
            // Sign In Data
            'CHECKLIST_DATE'=>isset($request->checklist_date)? date("Y-m-d", strtotime($request->checklist_date)) : "",
            'SAFTYCHECKLIST_NO_PK' =>1,
            'SIGN_IN_DATE' => $sign_in_date,
            'BAND_IN_PLACE' => $request->band_in_place ? $request->band_in_place : 0,
            'SURGERY' => $request->surgery ? $request->surgery : 0,
            'SITENSIDE' => $request->sitenside ? $request->sitenside : 0,
            'INFORM_CONSENT' => $request->inform_consent ? $request->inform_consent : 0,
            'NA' => $request->na ? $request->na : 0,
            'SITE_MARKING' => $request->site_marking ? $request->site_marking : 0,
            'MARKED_APP' => $request->marked_app ? $request->marked_app : 0,
            'MARKING_METHOD' => $request->marking_method ? $request->marking_method : 0,
            'ANES_MEDICATION' => $request->anes_medication,
            'ALLERGY' => $request->allergy,
            'ASPIRATION_RISK' => $request->aspiration_risk,
            'BLOOD_RISK' => $request->blood_risk,
            'BLOOD_RISK_TEXT' => $request->blood_risk_text ? $request->blood_risk_text : 'empty',
            'BLOOD_GROUP_TEXT' => $request->blood_group_text ? $request->blood_group_text : 'empty',
            'REQUIRED' => $request->required ? $request->required : 0,
            'NOT_REQUIRED' => $request->not_required ? $request->not_required : 0,
            'TLD' => $request->tld,
            'NECESS_DOCUMENT' => $request->necess_document ? $request->necess_document : 0,

            'HIS_PHY' => $request->his_phy ? $request->his_phy : 0,
            'ANES_SEDATION' => $request->anes_sedation ? $request->anes_sedation : 0,
            'IMAG_SEDATION' => $request->imag_sedation ? $request->imag_sedation : 0,
            'THRAOT_NOSE' => $request->thraot_nose,
            'ANES_DATE' => $anes_date,
            'ANES_PERSON_NO_FK' => $request->h_anesthetist ? $request->h_anesthetist : 0,
            'VERIFIED_BY_PERSON_NO_FK' => $request->h_nurse_name ? $request->h_nurse_name : 0,
            //  // Time Out Data
            'TIME_OUT_DATE' => $time_out_date,
            'CONSENT_AVAILABLE' => $request->consent_available,
            'PRE_OP_DIAGONOSIS' => $request->pre_op_diagnosis ? $request->pre_op_diagnosis : 'empty',
            'PLANNED_PROC' => $request->planned_proc ? $request->planned_proc : 'empty',
            'SITE_SIDES' => $request->site_sides ? $request->site_sides : 'empty',
            'SITE_MARKING_SKIN' => $request->site_marking_skin,
            'HAS_ANTI_PROPHYLAXIS' => $request->has_anti_prophylaxis,
            'ANTIBIOTIC_TIME' => $antibiotic_time,
            'CRITICAL_STEPS' => $request->critical_steps,
            'OPE_DURATION' => $request->ope_duration ? $request->ope_duration : 0,
            'BLOOD_ANTICIPATED' => $request->blood_anticipated,
            'EQUIPMENT_IVESTI_BED' => $request->equipment_ivesti_bed,
            'INTRAOP_DOSE' => $request->intraop_dose,
            'IMPLANT_CORRECT' => $request->implant_correct ? $request->implant_correct : 0,
            'IMPLANT_EXAMINATED' => $request->implant_examinated ? $request->implant_examinated : 0,
            'NA_IMPLANTABLE' => $request->na_implantable ? $request->na_implantable : 0,
            'PT_CONCERN' => $request->pt_concern ? $request->pt_concern : 0,
            'INSTRUMENTS_CONFIRMED' => $request->instruments_confirmed ? $request->instruments_confirmed : 0,
            'EQUIPMENT_HAND' => $request->equipment_hand ? $request->equipment_hand : 0,
            'ESSENTIAL_IMAGING' => $request->essential_imaging ? $request->essential_imaging : 0,
            'INFECTION_BUNDEL' => $request->infection_bundel ? $request->infection_bundel : 0,
            'VTE_UNDERTAKEN' => $request->vte_undertaken ? $request->vte_undertaken : 0,
            'INCISION_TIME' => $incision_time,
            'NURSE_PERSON_N0_FK' => $request->h_circulating ? $request->h_circulating : 0,
            // // Sign Out Data
            'SIGN_OUT' => $sign_out,
            'PROC_PERFORMED' => $request->proc_performed ? $request->proc_performed : 'empty',
            'POST_DIAGNOSIS' => $request->post_diagnosis ? $request->post_diagnosis : 'empty',
            'CORRECT_COUNT' => $request->correct_count,
            'PACK_REMOVED' => $request->pack_removed,
            'SPECIMEN' => $request->specimen,
            'SPCIMEN_LABELLED' => $request->spcimen_labelled,
            'ADDRESSED_PROBLEM' => $request->addressed_problem,
            'PT_KEY_CONCERN' => $request->pt_key_concern ? $request->pt_key_concern : 'empty',
            'IMPLANT_RECORD' => $request->implant_record,
            'END_ANES_TIME' => $end_anes_time,
            'END_ANES_SURGERY' => $end_anes_surgery,
            'REMARKS' => $request->remarks ? $request->remarks : 'empty',
            'NURSE_PERSON_NO' => $request->h_circulating_nurse ? $request->h_circulating_nurse : 0,
            'SCRUB_NURSE_PERSON_NO_FK' => $request->h_scrub ? $request->h_scrub : 0,
            'ANES_SIGN_OUT_PERSON_NO_FK' => $request->h_anesthetist_nurse ? $request->h_anesthetist_nurse : 0,
            'SURGEON_PERSON_NO_FK' => $request->h_surgeon ? $request->h_surgeon : 0,




        ];
        $sequence = DB::getSequence();
        $SAFTYCHECKLIST_NO_PK = $sequence->nextValue('SAFTYCHECKLIST_NO_PK_SEQ');

        if($id == ""){
            $data['SAFTYCHECKLIST_NO_PK'] =$SAFTYCHECKLIST_NO_PK;
            $data['au_entry_by'] =  $auth_id;
            $data['au_entry_at'] = date('y-m-d');
            $data['au_entry_session'] = 'sessoin';
            $data['AU_ENTRY_HOSPITAL_NO_FK'] = $ses_hospital_id;
            db::table('IPD_SAFTYCHECKLIST')->insert($data);

        }else {
            $data['au_update_by'] = $auth_id;
            $data['au_update_at'] = date('y-m-d');
            $data['AU_UPDATE_HOSPITAL_NO_FK'] = $ses_hospital_id;
            $data['au_update_session'] = 'sessoin';
            db::table('IPD_SAFTYCHECKLIST')->where('SAFTYCHECKLIST_NO_PK', $id)->update($data);
        }

        DB::commit();
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        // } catch (\Exception $e) {

        //     DB::rollback();
        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }


        return response()->json($message);
    }

    public function surgicalChecklistExportPDF($id)
{
    $admited_pat_info = DB::table('IPD_SAFTYCHECKLIST')->where('SAFTYCHECKLIST_NO_PK', $id)->first();

    $pat_info = DB::table('IPD_SAFTYCHECKLIST')
        ->select(
            DB::raw('FNC_PERSONNAME(ANES_PERSON_NO_FK) AS anesthetist_name'),
            DB::raw('FNC_PERSONNAME(VERIFIED_BY_PERSON_NO_FK) AS verified_nurse'),
            DB::raw('FNC_PERSONNAME(NURSE_PERSON_N0_FK) AS nurse_name'),
            DB::raw('FNC_PERSONNAME(NURSE_PERSON_NO) AS circulating_nurse'),
            DB::raw('FNC_PERSONNAME(SCRUB_NURSE_PERSON_NO_FK) AS scrub_nurse'),
            DB::raw('FNC_PERSONNAME(ANES_SIGN_OUT_PERSON_NO_FK) AS anesthetist'),
            DB::raw('FNC_PERSONNAME(SURGEON_PERSON_NO_FK) AS surgeon')
        )
        ->where('SAFTYCHECKLIST_NO_PK', 1)
        ->first();



     return view('admin.settings.surgical_checklist.surgical_checklist_form_print', [
        'admited_pat_info' => $admited_pat_info,
        'pat_info' => $pat_info
    ]);


}



















}
