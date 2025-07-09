<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">

<style>
    body {
        font-size: 18px;
    }

    .border-box {
        border: 1px solid #ccc;
        padding: 15px;
        height: 100%;
    }

    .section-title {
        font-weight: bold;
        text-align: center;
        margin-bottom: 10px;
        text-decoration: underline;
    }

    p {
        font-weight: bold;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .printable-area,
        .printable-area * {
            visibility: visible;
        }

        .printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }





    }
</style>
{{-- @dd($admited_pat_info) --}}
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm align-items-center">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">Surgical Safety Checklist</h5>
                <small>Checklist / Surgery Setup / Create</small>
            </div>

            <div class="col-md-2 d-flex justify-content-end">
                <a class="btn btn-md btn-warning mt-3" target="_blank"
                    href="{{ route('surgical-checklist.print', [$admited_pat_info->saftychecklist_no_pk]) }}">
                    PDF Export
                </a>
            </div>
        </div>


        <form action="{{ route('surgical-checklist.store') }}" method="POST" id="SURGICALCHECKLISTFORM">
            @csrf
            <input type="hidden"
                value="{{ isset($admited_pat_info->saftychecklist_no_pk) ? $admited_pat_info->saftychecklist_no_pk : '' }}"
                name="saftychecklist_no_pk">
            <div class="card printable-area">
                <div class="card-header">

                    <h5>Surgical Safety Checklist</h5>
                    <p class="mb-0">Adapted from WHO Surgical Safety Checklist and Includes all JCIA requirements</p>

                </div>

                <div class="card-body mt-2">
                    <div class="text-end mb-2">
                        <strong>Date:</strong>
                        <input type="date" name="checklist_date"
                            value="{{ @$admited_pat_info->CHECKLIST_DATE ? date('Y-m-d', strtotime(@$admited_pat_info->CHECKLIST_DATE)) : date('Y-m-d') }}"
                          autocomplete="off"  class="form-control d-inline-block w-auto">

                    </div>
                    <div class="row g-3 print-row">

                        <!-- SIGN IN COLUMN -->
                        <div class="col-md-4 print-column">
                            <div class="border-box">
                                <div class="section-title">SIGN IN<br><small>(Before Induction of Anaesthesia)</small>
                                </div>
                                <p><strong>Time:</strong> @php $sign_in_date = explode(" ", @$admited_pat_info->sign_in_date);@endphp


                                    <input type="time" name="sign_in_date" value="{{ $sign_in_date[1] ?? '' }}"
                                        class="form-control d-inline-block w-auto">
                                </p>


                                <p><strong>Patient has confirmed</strong></p>
                                <div class="form-check">
                                    <input class="form-check-input" name="band_in_place" type="checkbox" value="1"
                                        {{ @$admited_pat_info->band_in_place == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Identity and ID band in place</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" name="surgery" type="checkbox" value="1"
                                        {{ @$admited_pat_info->surgery == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Correct Procedure/surgery</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" name="sitenside" type="checkbox" value="1"
                                        {{ @$admited_pat_info->sitenside == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Correct site and side</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" name="inform_consent" type="checkbox" value="1"
                                        {{ @$admited_pat_info->inform_consent == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Signed the Informed Consent</label>
                                </div>

                                <hr>
                                <p><strong>Site Marking</strong></p>

                                <div class="form-check">
                                    <input class="form-check-input" name="na" type="checkbox" value="1"
                                        {{ @$admited_pat_info->na == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">NA</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" name="site_marking" type="checkbox" value="1"
                                        {{ @$admited_pat_info->site_marking == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Patient participated in site marking</label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" name="marked_app" type="checkbox" value="1"
                                        {{ @$admited_pat_info->marked_app == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Site is marked using the approved</label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" name="marking_method" type="checkbox" value="1"
                                        {{ @$admited_pat_info->marking_method == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Site marking method</label>
                                </div>

                                <p><strong>Anesthesia Safety</strong></p>
                                <p>Anesthesia machine & medication check complete?</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="anes_medication"
                                        id="anesthesia_yes" value="1"
                                        {{ @$admited_pat_info->anes_medication == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="anesthesia_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="anes_medication"
                                        id="anesthesia_no" value="0">
                                    <label class="form-check-label" for="anesthesia_no">No</label>
                                </div>

                                <p>Does Patient Have a Known allergy:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="allergy" value="1"
                                        {{ @$admited_pat_info->allergy == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="allergy" value="0"
                                        {{ @$admited_pat_info->allergy == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label">No</label>
                                </div>

                                <p>Difficult airway/aspiration risk:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="aspiration_risk"
                                        value="1"
                                        {{ @$admited_pat_info->aspiration_risk == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="aspiration_risk"
                                        value="0"
                                        {{ @$admited_pat_info->aspiration_risk == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label">No</label>
                                </div>

                                <p>Blood loss risk (&gt;500ml):</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="blood_risk"
                                        id="blood_loss_yes" value="1"
                                        {{ @$admited_pat_info->blood_risk == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="blood_loss_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="blood_risk"
                                        id="blood_loss_no" value="0"
                                        {{ @$admited_pat_info->blood_risk == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="blood_loss_no">No</label>
                                </div>
                                <hr>

                                <p>If Yes: IV access and blood arranged</p>
                                <p>
                                    Units:
                                    <input type="text" name="blood_risk_text" class="form-control mb-2"
                                        value="{{ @$admited_pat_info->blood_risk_text }}" autocomplete="off">
                                    Blood group:
                                    <input type="text" name="blood_group_text" class="form-control"
                                        value="{{ @$admited_pat_info->blood_group_text }}" autocomplete="off">
                                </p>

                                <p>Implant:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="required"
                                        id="implant_required" value="1"
                                        {{ @$admited_pat_info->required == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="implant_required">Required</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="not_required"
                                        id="implant_not_required" value="1"
                                        {{ @$admited_pat_info->not_required == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="implant_not_required">Not Required</label>
                                </div>
                                <br>

                                <p>Wearing TLD badge:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tld" id="tld_yes"
                                        value="1" {{ @$admited_pat_info->tld == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tld_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tld" id="tld_no"
                                        value="0" {{ @$admited_pat_info->tld == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tld_no">No</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tld" id="tld_na"
                                        value="2" {{ @$admited_pat_info->tld == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tld_na">NA</label>
                                </div>
                                <hr>

                                <p><strong>Documentation</strong></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="necess_document"
                                        value="1"
                                        {{ @$admited_pat_info->necess_document == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">All necessary documentation are available and
                                        complete</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="his_phy" value="1"
                                        {{ @$admited_pat_info->his_phy == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">History and Physical examination</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="anes_sedation"
                                        value="1" {{ @$admited_pat_info->anes_sedation == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Anesthesia/sedation consent</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="imag_sedation"
                                        value="1" {{ @$admited_pat_info->imag_sedation == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Imaging and laboratory tests</label>
                                </div>
                                <br>

                                <p>Throat/nose pack:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="thraot_nose"
                                        id="throat_yes" value="0"
                                        {{ @$admited_pat_info->thraot_nose == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="throat_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="thraot_nose" id="throat_no"
                                        value="1" {{ @$admited_pat_info->thraot_nose == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="throat_no">No</label>
                                </div>
                                <br><br><br><br>

                                <p>Time of Induction: @php
                                    $anes_date = explode(' ', @$admited_pat_info->anes_date);
                                @endphp <input type="time" name="anes_date"
                                        value="{{ $anes_date[1] ?? '' }}"
                                        class="form-control d-inline-block w-auto mb-2" autocomplete="off"></p>
                                <p>Name of Anesthetist: <input type="text" name="anesthetist" id="anesthetist"
                                        value="{{ @$pat_info->anesthetist_name }}" class="form-control mb-2" autocomplete="off"> <input
                                        type="hidden" name="h_anesthetist" id="h_anesthetist"> </p>
                                <p>Signature: <input type="text" class="form-control mb-2" ></p>
                                <p>Verified by Nurse: <input type="text" name="nurse_name" id="nurse_name"
                                        value="{{ @$pat_info->verified_nurse }}" class="form-control mb-2" autocomplete="off"> <input
                                        type="hidden" name="h_nurse_name" id="h_nurse_name"></p>
                            </div>
                        </div>


                        <!-- END SIGN IN COLUMN -->


                        <!-- TIME OUT COLUMN -->
                        <div class="col-md-4 print-column">
                            <div class="border-box">
                                <div class="section-title">TIME OUT<br><small>(Before Skin Incision)</small></div>
                                <p><strong>Time:</strong> @php $time_out_date = explode(" ", @$admited_pat_info->time_out_date); @endphp

                                    <input type="time" name="time_out_date" value="{{ $time_out_date[1] ?? '' }}"
                                        class="form-control d-inline-block w-auto" autocomplete="off">
                                </p>

                                <p><strong>Surgical/Procedure Team Check</strong></p>


                                <p>All required team members are present and ready to start Surgeon, anesthesia
                                    professional
                                    and nurse verbally confirm:</p>
                                <p>Patient Identity confirmed Read out approved two identifiers "Full name and UHID No."
                                    (Another staff/anesthetist simultaneously checks and confirms with the patient ID)
                                </p>
                                <p>Consent available and appropriate:</p>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="consent_available"
                                        id="Consent_yes" value="1"
                                        {{ @$admited_pat_info->consent_available == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Consent_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="consent_available"
                                        id="Consent_no" value="0"
                                        {{ @$admited_pat_info->consent_available == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Consent_no">No</label>
                                </div>

                                <hr>

                                <p><strong>Procedure/Surgical Site/Side Identification </strong></p>
                                <p>Pre-op diagnosis:
                                    <input type="text" name="pre_op_diagonosis" class="form-control mb-2"
                                        value="{{ @$admited_pat_info->pre_op_diagonosis }}" autocomplete="off">
                                </p>
                                <p>Planned procedure:
                                    <input type="text" name="planned_proc" class="form-control mb-2"
                                        value="{{ @$admited_pat_info->planned_proc }}" autocomplete="off">
                                </p>
                                <p>Correct site/side:
                                    <input type="text" name="site_sides" class="form-control d-inline-block w-50"
                                        value="{{ @$admited_pat_info->site_sides }}" autocomplete="off">
                                </p>

                                <p>Site marking still visible after draping and skin preparation:</p>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="site_marking_skin"
                                        id="site_yes" value="1"
                                        {{ @$admited_pat_info->site_marking_skin == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="site_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="site_marking_skin"
                                        id="site_no" value="0"
                                        {{ @$admited_pat_info->site_marking_skin == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="site_no">No</label>
                                </div>

                                <p><strong>Prophylaxis Antibiotic</strong></p>

                                <p>Antibiotic prophylaxis given within the last 60 Minutes:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="has_anti_prophylaxis"
                                        id="yes_option" value="1"
                                        {{ @$admited_pat_info->has_anti_prophylaxis == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="yes_option">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="has_anti_prophylaxis"
                                        id="no_option" value="0"
                                        {{ @$admited_pat_info->has_anti_prophylaxis == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="no_option">No</label>
                                </div>

                                <div id="" class="mt-2">
                                    <p>If No,Time given of antibiotic administered: @php $antibiotic_time = explode(" ", @$admited_pat_info->antibiotic_time); @endphp
                                        <input type="time" name="antibiotic_time"
                                            value="{{ $antibiotic_time[1] ?? '' }}"
                                            class="form-control d-inline-block w-auto" autocomplete="off">
                                    </p>
                                </div>

                                <hr>

                                <p><strong>Anticipated Critical Events</strong></p>

                                <p>Critical steps reviewed:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="critical_steps"
                                        id="critical_yes" value="1"
                                        {{ @$admited_pat_info->critical_steps == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="critical_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="critical_steps"
                                        id="critical_no" value="0"
                                        {{ @$admited_pat_info->critical_steps == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="critical_no">No</label>
                                </div>

                                <p>Operative duration:</p>
                                <input type="text" name="ope_duration"
                                    class="form-control d-inline-block w-auto mb-2"
                                    value="{{ @$admited_pat_info->ope_duration }}" autocomplete="off">

                                <p>Significant blood loss:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="blood_anticipated"
                                        id="blood_loss_yes" value="1"
                                        {{ @$admited_pat_info->blood_anticipated == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="blood_loss_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="blood_anticipated"
                                        id="blood_loss_no" value="0"
                                        {{ @$admited_pat_info->blood_anticipated == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="blood_loss_no">No</label>
                                </div>

                                <p>Special equipment needed or special investigation or bed required:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="equipment_ivesti_bed"
                                        id="equipment_yes" value="1"
                                        {{ @$admited_pat_info->equipment_ivesti_bed == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="equipment_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="equipment_ivesti_bed"
                                        id="equipment_no" value="0"
                                        {{ @$admited_pat_info->equipment_ivesti_bed == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="equipment_no">No</label>
                                </div>

                                <p>Repeat antibiotic dose intra-operative:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="intraop_dose"
                                        id="repeat_antibiotic_yes" value="1"
                                        {{ @$admited_pat_info->intraop_dose == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="repeat_antibiotic_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="intraop_dose"
                                        id="repeat_antibiotic_no" value="0"
                                        {{ @$admited_pat_info->intraop_dose == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="repeat_antibiotic_no">No</label>
                                </div>

                                <hr>

                                <p><strong>Implant Devices</strong></p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="implant_correct"
                                        value="1"
                                        {{ @$admited_pat_info->implant_correct == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Correct type available</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="implant_examinated"
                                        value="1"
                                        {{ @$admited_pat_info->implant_examinated == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Surgeon examined implant</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="na_implantable"
                                        value="1" {{ @$admited_pat_info->na_implantable == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">NA</label>
                                </div>

                                <hr>

                                <p><strong>Anesthesia Team Verification</strong></p>
                                <p>Any patient-specific concerns:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pt_concern"
                                        id="concerns_yes" value="1"
                                        {{ @$admited_pat_info->pt_concern == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="concerns_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pt_concern"
                                        id="concerns_no" value="0"
                                        {{ @$admited_pat_info->pt_concern == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="concerns_no">No</label>
                                </div>

                                <p><strong>Nursing Team Verification</strong></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="instruments_confirmed"
                                        value="1"
                                        {{ @$admited_pat_info->instruments_confirmed == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Sterility of instruments been confirmed (including
                                        indicator results)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="equipment_hand"
                                        value="1" {{ @$admited_pat_info->equipment_hand == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">All needed instruments and medical technology
                                        equipment
                                        on hand, correct and functional</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="essential_imaging"
                                        value="1"
                                        {{ @$admited_pat_info->essential_imaging == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Essential imaging displayed</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="infection_bundel"
                                        value="1"
                                        {{ @$admited_pat_info->infection_bundel == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Surgical site infection bundle been
                                        undertaken</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="vte_undertaken"
                                        value="1" {{ @$admited_pat_info->vte_undertaken == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Has, VTE prophylaxis been undertaken?</label>
                                </div> <br> <br>



                                <p>Time of Incision: @php $incision_time = explode(" ", @$admited_pat_info->incision_time); @endphp <input type="time"
                                        class="form-control d-inline-block w-auto mb-2" name="incision_time"
                                        value="{{ $incision_time[1] ?? '' }}" autocomplete="off"></p>
                                <p>Circulating Nurse: <input type="text" name="circulating" id="circulating"
                                        value="{{ $pat_info->nurse_name }}" class="form-control" autocomplete="off"> <input
                                        type="hidden" name="h_circulating" id="h_circulating" ></p>
                                <p>Signature: <input type="text" class="form-control"></p>
                            </div>
                        </div>

                        <!-- SIGN OUT COLUMN -->
                        <div class="col-md-4 print-column">
                            <div class="border-box">
                                <div class="section-title">SIGN OUT<br><small>(Patient leaves the operating room)</small></div>
                                <p><strong>Time:</strong> @php $sign_out = explode(" ", @$admited_pat_info->sign_out); @endphp
                                    <input type="time" name="sign_out"
                                        class="form-control d-inline-block w-auto mb-2"
                                        value="{{ $sign_out[1] ?? '' }}" autocomplete="off">
                                </p>


                                <p><strong>Nurse verbally confirms with the team</strong></p>

                                <label class="form-check-label">Procedure performed:</label>
                                <input type="text" class="form-control mb-2" name="proc_performed"
                                    value="{{ @$admited_pat_info->proc_performed }}" autocomplete="off">

                                <label class="form-check-label">Post-op diagnosis:</label>
                                <input type="text" class="form-control mb-2" name="post_diagnosis"
                                    value="{{ @$admited_pat_info->post_diagnosis }}" autocomplete="off">

                                <p>Instruments, sponge and needle counts are correct:</p>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="correct_count"
                                        id="instrument_yes" value="1"
                                        {{ @$admited_pat_info->correct_count == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="instrument_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="correct_count"
                                        id="instrument_no" value="0"
                                        {{ @$admited_pat_info->correct_count == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="instrument_no">No</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="correct_count"
                                        id="instrument_na" value="2"
                                        {{ @$admited_pat_info->correct_count == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="instrument_na">NA</label>
                                </div>



                                <p>Throat pack or nose packs removed:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pack_removed"
                                        id="nose_yes" value="1"
                                        {{ @$admited_pat_info->pack_removed == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pack_removed"
                                        id="nose_no" value="0"
                                        {{ @$admited_pat_info->pack_removed == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label">No</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pack_removed"
                                        id="nose_na" value="2"
                                        {{ @$admited_pat_info->pack_removed == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label">NA</label>
                                </div>

                                <p>Is there any specimen?</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="specimen" id="specimen_yes"
                                        value="1" {{ @$admited_pat_info->specimen == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="specimen" id="specimen_no"
                                        value="0" {{ @$admited_pat_info->specimen == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label">No</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="specimen" id="specimen_na"
                                        value="2" {{ @$admited_pat_info->specimen == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label">NA</label>
                                </div>

                                <p>Has specimen been labelled?</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="spcimen_labelled"
                                        id="labelled_yes" value="1"
                                        {{ @$admited_pat_info->spcimen_labelled == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="spcimen_labelled"
                                        id="labelled_no" value="0"
                                        {{ @$admited_pat_info->spcimen_labelled == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label">No</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="spcimen_labelled"
                                        id="labelled_na" value="2"
                                        {{ @$admited_pat_info->spcimen_labelled == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label">NA</label>
                                </div>

                                <p>Whether there are any medical technology/equipment problems to be addressed?</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="addressed_problem"
                                        id="technology_yes" value="1"
                                        {{ @$admited_pat_info->addressed_problem == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="addressed_problem"
                                        id="technology_no" value="0"
                                        {{ @$admited_pat_info->addressed_problem == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label">No</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="addressed_problem"
                                        id="technology_na" value="2"
                                        {{ @$admited_pat_info->addressed_problem == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label">NA</label>
                                </div>

                                <p>Key concerns for recovery:</p>
                                <input type="text" class="form-control mb-2" name="pt_key_concern"
                                    value="{{ @$admited_pat_info->pt_key_concern }}" autocomplete="off">

                                <p>Implant registry logged into implantable devices log and patient record:</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="implant_record"
                                        id="patient_yes" value="1"
                                        {{ @$admited_pat_info->implant_record == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="implant_record"
                                        id="patient_no" value="0"
                                        {{ @$admited_pat_info->implant_record == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label">No</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="implant_record"
                                        id="patient_na" value="2"
                                        {{ @$admited_pat_info->implant_record == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label">NA</label>
                                </div>


                                <p>End of Anesthesia Time:</p>
                                @php $end_anes_time = explode(" ", @$admited_pat_info->end_anes_time); @endphp
                                <input type="time" class="form-control d-inline-block w-auto mb-2"
                                    name="end_anes_time" value="{{ $end_anes_time[1] ?? '' }}" autocomplete="off">

                                <p>End of Surgery Time:</p>
                                @php $end_anes_surgery = explode(" ", @$admited_pat_info->end_anes_surgery); @endphp
                                <input type="time" class="form-control d-inline-block w-auto mb-2"
                                    name="end_anes_surgery" value="{{ $end_anes_surgery[1] ?? '' }}" autocomplete="off">

                                <p>Remarks:</p>
                                <input type="text" class="form-control mb-2" name="remarks"
                                    value="{{ @$admited_pat_info->remarks }}" autocomplete="off"> <br> <br> <br> <br>

                                <p>Name of Circulating Nurse:<input type="text" name="circulating_nurse"
                                        id="circulating_nurse" value="{{ @$pat_info->circulating_nurse }}"
                                        class="form-control mb-2" autocomplete="off"> <input type="hidden" name="h_circulating_nurse"
                                        id="h_circulating_nurse"></p>

                                <p>Signature:
                                    <input type="text" class="form-control mb-2">
                                </p>

                                <p>Scrub Nurse:<input type="text" name="scrub" id="scrub"
                                        value="{{ @$pat_info->scrub_nurse }}" class="form-control mb-2" autocomplete="off"> <input
                                        type="hidden" name="h_scrub" id="h_scrub">
                                </p>
                                <p>Signature: <input type="text" class="form-control mb-2"></p>

                                <p>Anesthetist: <input type="text" name="anesthetist_nurse" id="anesthetist_nurse"
                                        value="{{ @$pat_info->anesthetist }}" class="form-control mb-2"autocomplete="off"> <input
                                        type="hidden" name="h_anesthetist_nurse" id="h_anesthetist_nurse" ></p>
                                <p>Signature: <input type="text" class="form-control mb-2"></p>

                                <p>Surgeon:<input type="text" name="surgeon" id="surgeon"
                                        value="{{ @$pat_info->surgeon }}" class="form-control mb-2" autocomplete="off"> <input
                                        type="hidden" name="h_surgeon" id="h_surgeon"></p>
                                <p>Signature: <input type="text" class="form-control mb-2"></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-4 text-center">
                @php
                    $redirect_url = route('surgical-checklist.sign-in');
                @endphp
                <button type="submit" class="btn btn-success btn-lg m-3 float-center"
                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
            </div>

        </form>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#anesthetist', 'h_anesthetist', "employee_ind", 1);
    openDoctorAutocomplete('#nurse_name', 'h_nurse_name', "employee_ind", 1);
    openDoctorAutocomplete('#circulating', 'h_circulating', "employee_ind", 1);
    openDoctorAutocomplete('#circulating_nurse', 'h_circulating_nurse', "employee_ind", 1);
    openDoctorAutocomplete('#scrub', 'h_scrub', "employee_ind", 1);
    openDoctorAutocomplete('#anesthetist_nurse', 'h_anesthetist_nurse', "employee_ind", 1);
    openDoctorAutocomplete('#surgeon', 'h_surgeon', "employee_ind", 1);
</script>
