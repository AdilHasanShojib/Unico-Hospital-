<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OT Checklist Form</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">



    <style>
        .fs-12 {
            font-size: 14px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered {
            border: 1px solid #333;
        }

        td {
            font-size: 13px;
            border: 1px solid #333;
            padding-right: 3px;
        }


        .form-check {
            position: relative;
            display: block;
            padding-left: 1.25rem;
        }

        .form-check-inline {
            display: inline-block !important;
            margin-right: 1rem;
        }

        .form-check-input {
            position: static;
            margin-top: 0.3rem;
            margin-left: -1.25rem;
        }

        .form-check-label {
            margin-bottom: 0px !important;
        }

        .w-16 {
            width: 16%;
        }

        .w-8 {
            width: 8%;
        }

        .w-15 {
            width: 15%;
        }

        .w-25 {
            width: 25%;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .header>tbody>tr>td,
        .header>thead>tr>td {
            border: none;
        }

        body {
            /* margin-top: 4cm; */
            margin-bottom: 0.6cm;
            margin-left: 1cm;
        }

        .footer-table {
            /* position: absolute;
            bottom: 0px;
            width: 100%; */

            margin-top: 10px;
        }

        td {
            page-break-inside: avoid
        }

        .removeMargin p {
            margin: 0;
        }

        p {
            font-weight: bold;
        }

        input[type="text"],
        input[type="time"] {
            width: 95%;
            font-size: 12px;
        }

        label {
            display: inline-block;
            margin-bottom: 3px;
        }
    </style>
</head>

<body onload="window.print()">

    <table class="table header">
        <thead>
            <tr>
                <td style="width:65%">
                    <ul style="list-style: none; padding-left: 0; display:inline-block;">
                        <li><b>IP
                                No:</b>&nbsp;<span></span>
                        </li>
                        <li><img style="" src="data:image/png;base64,"></li>
                        <li><span><b>Name:</b></span>
                            &nbsp;<span><b>Age:</b></span>
                            &nbsp;<b>Gender:</b><span></span>
                            &nbsp;<b>Bed:</b>&nbsp;<span></span>
                        </li>
                        <li><b>Con. Number :</b>&nbsp;<span></span></li>
                        <li><b>Consultant Name:</b>&nbsp;<span></span></li>
                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b>&nbsp;<span></span>
                        </li>
                        <li><img style="" src="data:image/png;base64,"></li>
                        <li><b>Phone:</b>&nbsp;<span></span>
                        </li>
                        <li><b>IP
                                Date:</b>&nbsp;<span></span>
                        </li>

                        <li><b>Date of
                                Discharge:</b>&nbsp;<span></span>
                        </li>


                    </ul>
                </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="2">
                    <div
                        style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
                        <span style="font-size: 16px;"><b>Intra-Operative Nursing Record</b></span>

                    </div>

                    <table width="100%" class="mt-4 table table-bordered">
                        <tbody>
                            <tr>
                                <th class="section-title">
                                    SIGN IN<br /><small>(Before Induction of Anaesthesia)</small> <br>
                                    <p>
                                        <strong>Time:</strong>
                                        @php $sign_in_date = explode(" ", @$admited_pat_info->sign_in_date); @endphp
                                        <input type="time" name="sign_in_date" value="{{ $sign_in_date[1] ?? '' }}"
                                            class="form-control d-inline-block w-auto" />
                                    </p>
                                </th>
                                <th class="section-title">
                                    TIME OUT<br /><small>(Before Skin Incision)</small>
                                    <p>
                                        <strong>Time:</strong>
                                        @php $time_out_date = explode(" ", @$admited_pat_info->time_out_date); @endphp
                                        <input type="time" name="time_out_date" value="{{ $time_out_date[1] ?? '' }}"
                                            class="form-control d-inline-block w-auto" />
                                    </p>
                                </th>
                                <th class="section-title">
                                    SIGN OUT<br /><small>(Patient leaves the operating room)</small>
                                    <p>
                                        <strong>Time:</strong>
                                        @php $sign_out = explode(" ", @$admited_pat_info->sign_out); @endphp
                                        <input type="time" name="sign_out" value="{{ $sign_out[1] ?? '' }}"
                                            class="form-control d-inline-block w-auto mb-2" />
                                    </p>
                                </th>
                            </tr>

                            <tr>
                                <td>
                                    <p><strong>Patient has confirmed</strong></p>
                                    <div class="form-check">
                                        <input class="form-check-input" name="band_in_place" type="checkbox"
                                            value="1"
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
                                        <input class="form-check-input" name="inform_consent" type="checkbox"
                                            value="1"
                                            {{ @$admited_pat_info->inform_consent == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">Signed the Informed Consent</label>
                                    </div>

                                    <p><strong>Site Marking</strong></p>

                                    <div class="form-check">
                                        <input class="form-check-input" name="na" type="checkbox" value="1"
                                            {{ @$admited_pat_info->na == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">NA</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" name="site_marking" type="checkbox"
                                            value="1" {{ @$admited_pat_info->site_marking == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">Patient participated in site marking</label>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" name="marked_app" type="checkbox" value="1"
                                            {{ @$admited_pat_info->marked_app == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">Site is marked using the approved</label>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" name="marking_method" type="checkbox"
                                            value="1"
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



                                </td>

                                <td>
                                    <p><strong>Surgical/Procedure Team Check</strong></p>
                                    <p>All required team members are present and ready to start Surgeon, anesthesia
                                        professional
                                        and nurse verbally confirm:</p>
                                    <p>Patient Identity confirmed Read out approved two identifiers "Full name and UHID
                                        No."
                                        (Another staff/anesthetist simultaneously checks and confirms with the patient
                                        ID)
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
                                    <p><strong>Procedure/Surgical Site/Side Identification </strong></p>
                                    <p>Pre-op diagnosis:
                                        <input type="text" name="pre_op_diagonosis" class="form-control mb-2"
                                            value="{{ @$admited_pat_info->pre_op_diagonosis }}">
                                    </p>
                                    <p>Planned procedure:
                                        <input type="text" name="planned_proc" class="form-control mb-2"
                                            value="{{ @$admited_pat_info->planned_proc }}">
                                    </p>
                                    <p>Correct site/side:
                                        <input type="text" name="site_sides"
                                            class="form-control d-inline-block w-50"
                                            value="{{ @$admited_pat_info->site_sides }}">
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


                                </td>


                                <td>
                                    <p><strong>Nurse verbally confirms with the team</strong></p>

                                    <label class="form-check-label">Procedure performed:</label>
                                    <input type="text" class="form-control mb-2" name="proc_performed"
                                        value="{{ @$admited_pat_info->proc_performed }}">

                                    <label class="form-check-label">Post-op diagnosis:</label>
                                    <input type="text" class="form-control mb-2" name="post_diagnosis"
                                        value="{{ @$admited_pat_info->post_diagnosis }}">

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
                                        <input class="form-check-input" type="radio" name="specimen"
                                            id="specimen_yes" value="1"
                                            {{ @$admited_pat_info->specimen == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="specimen"
                                            id="specimen_no" value="0"
                                            {{ @$admited_pat_info->specimen == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="specimen"
                                            id="specimen_na" value="2"
                                            {{ @$admited_pat_info->specimen == 2 ? 'checked' : '' }}>
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


                                </td>
                            </tr>

                            <tr>
                                <td>
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


                                    <p>If Yes: IV access and blood arranged</p>
                                    <p>
                                        Units:
                                        <input type="text" name="blood_risk_text" class="form-control mb-2"
                                            value="{{ @$admited_pat_info->blood_risk_text }}">
                                        Blood group:
                                        <input type="text" name="blood_group_text" class="form-control"
                                            value="{{ @$admited_pat_info->blood_group_text }}">
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
                                        <label class="form-check-label" for="implant_not_required">Not
                                            Required</label>
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

                                    <p><strong>Documentation</strong></p>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="necess_document"
                                            value="1"
                                            {{ @$admited_pat_info->necess_document == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">All necessary documentation are available and
                                            complete</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="his_phy"
                                            value="1" {{ @$admited_pat_info->his_phy == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">History and Physical examination</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="anes_sedation"
                                            value="1"
                                            {{ @$admited_pat_info->anes_sedation == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">Anesthesia/sedation consent</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="imag_sedation"
                                            value="1"
                                            {{ @$admited_pat_info->imag_sedation == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">Imaging and laboratory tests</label>
                                    </div>



                                </td>

                                <td>
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
                                                class="form-control d-inline-block w-auto">
                                        </p>
                                    </div> <br> <br>



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
                                        value="{{ @$admited_pat_info->ope_duration }}">

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
                                    </div> <br> <br>

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
                                    </div> <br> <br>

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
                                    </div> <br> <br>


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
                                            value="1"
                                            {{ @$admited_pat_info->na_implantable == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">NA</label>
                                    </div>



                                </td>
                                <td>
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
                                    </div> <br> <br>

                                    <p>Key concerns for recovery:</p>
                                    <input type="text" class="form-control mb-2" name="pt_key_concern"
                                        value="{{ @$admited_pat_info->pt_key_concern }}"> <br> <br>

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
                                    </div> <br> <br>

                                    <p>End of Anesthesia Time:</p>
                                    @php $end_anes_time = explode(" ", @$admited_pat_info->end_anes_time); @endphp
                                    <input type="time" class="form-control d-inline-block w-auto mb-2"
                                        name="end_anes_time" value="{{ $end_anes_time[1] ?? '' }}"> <br> <br>

                                    <p>End of Surgery Time:</p>
                                    @php $end_anes_surgery = explode(" ", @$admited_pat_info->end_anes_surgery); @endphp
                                    <input type="time" class="form-control d-inline-block w-auto mb-2"
                                        name="end_anes_surgery" value="{{ $end_anes_surgery[1] ?? '' }}"> <br> <br>

                                    <p>Remarks:</p>
                                    <input type="text" class="form-control mb-2" name="remarks"
                                        value="{{ @$admited_pat_info->remarks }}">

                                </td>
                            </tr>



                            <tr>
                                <td>
                                    <p>Throat/nose pack:</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="thraot_nose"
                                            id="throat_yes" value="0"
                                            {{ @$admited_pat_info->thraot_nose == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="throat_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="thraot_nose"
                                            id="throat_no" value="1"
                                            {{ @$admited_pat_info->thraot_nose == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="throat_no">No</label>
                                    </div> <br> <br> <br>


                                    <p>Time of Induction: @php
                                        $anes_date = explode(' ', @$admited_pat_info->anes_date);
                                    @endphp <input type="time" name="anes_date"
                                            value="{{ $anes_date[1] ?? '' }}"
                                            class="form-control d-inline-block w-auto"></p> <br> <br> <br>

                                    <p>Name of Anesthetist: <input type="text" name="anesthetist" id="anesthetist"
                                            value="{{ @$pat_info->anesthetist_name }}" class="form-control mb-2">
                                        <input type="hidden" name="h_anesthetist" id="h_anesthetist"> <br> <br> <br>
                                    </p>
                                    <p>Signature: <input type="text" class="form-control w-75 mb-2"></p> <br> <br>
                                    <br>
                                    <p>Verified by Nurse: <input type="text" name="nurse_name" id="nurse_name"
                                            value="{{ @$pat_info->verified_nurse }}" class="form-control mb-2">
                                        <input type="hidden" name="h_nurse_name" id="h_nurse_name">
                                    </p>


                                </td>

                                <td>
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
                                        <label class="form-check-label">Sterility of instruments been confirmed
                                            (including
                                            indicator results)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="equipment_hand"
                                            value="1"
                                            {{ @$admited_pat_info->equipment_hand == 1 ? 'checked' : '' }}>
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
                                            value="1"
                                            {{ @$admited_pat_info->vte_undertaken == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">Has, VTE prophylaxis been undertaken?</label>
                                    </div> <br> <br>

                                    <p>Time of Incision: @php $incision_time = explode(" ", @$admited_pat_info->incision_time); @endphp <input type="time"
                                            class="form-controld-inline-block w-auto mb-2" name="incision_time"
                                            value="{{ $incision_time[1] ?? '' }}"></p>
                                    <p>Circulating Nurse: <input type="text" name="circulating" id="circulating"
                                            value="{{ $pat_info->nurse_name }}" class="form-control"> <input
                                            type="hidden" name="h_circulating" id="h_circulating"></p>
                                    <p>Signature: <input type="text" class="form-control w-75"></p>





                                </td>

                                <td>



                                    <p>Name of Circulating Nurse: <br><input type="text" name="circulating_nurse"
                                            id="circulating_nurse" value="{{ @$pat_info->circulating_nurse }}"
                                            class="form-control mb-2"> <input type="hidden"
                                            name="h_circulating_nurse" id="h_circulating_nurse"></p>

                                    <p>Signature: <br>
                                        <input type="text" class="form-control mb-2 w-75">
                                    </p>

                                    <p>Scrub Nurse: <br><input type="text" name="scrub" id="scrub"
                                            value="{{ @$pat_info->scrub_nurse }}" class="form-control mb-2"> <input
                                            type="hidden" name="h_scrub" id="h_scrub">
                                    </p>
                                    <p>Signature: <br> <input type="text" class="form-control mb-2 w-75"></p>

                                    <p>Anesthetist: <br> <input type="text" name="anesthetist_nurse"
                                            id="anesthetist_nurse" value="{{ @$pat_info->anesthetist }}"
                                            class="form-control mb-2"> <input type="hidden"
                                            name="h_anesthetist_nurse" id="h_anesthetist_nurse"></p>

                                    <p>Signature: <br> <input type="text" class="form-control mb-2 w-75"></p>

                                    <p>Surgeon: <br><input type="text" name="surgeon" id="surgeon"
                                            value="{{ @$pat_info->surgeon }}" class="form-control mb-2"> <input
                                            type="hidden" name="h_surgeon" id="h_surgeon"></p>
                                    <p>Signature: <br><input type="text" class="form-control mb-2 w-75"></p>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
