<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>
    <link rel="stylesheet" href="style.css">
</head>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto&display=swap" rel="stylesheet"></head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .a4-page {
        width: 210mm;
        height: 297mm;
        padding: 1in;
    }

    .id-card-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5in;
    }

    .id-card-container .card-img {
        width: 5.4cm;
        height: 8.58cm;
    }

    .id-card-container div:first-child {
        position: relative;
    }

    .id-card-container .student-photo {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 15mm;
        width: 0.7in;
        height: 0.7in;
        object-fit: cover;
        object-position: center;
        border-radius: 50%;
        border: 2.5px solid #202A5F;
    }

    .id-card-container .student-id {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 41mm;
        font-size: 8pt;
        font-weight: 700;
        background-color: #2F57A7;
        color: white;
        padding: 3px 15px;
        border-radius: 12px;
        text-transform: uppercase;
    }

    .id-card-container .student-info {
        position: absolute;
        left: 6mm;
        top: 48mm;
        font-size: 7.5pt;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .id-card-container .student-info span {
        font-weight: 700;
    }

    .id-card-container .head-sign {
        position: absolute;
        right: 3mm;
        bottom: 34px;
        font-size: 6.5pt;
        font-weight: 700;
    }

    .id-card-container .head-sign img {
        width: 15mm;
        display: block;
        margin-inline: auto;
    }

    .id-card-container .head-sign span {
        display: block;
    }

    .id-card-container .head-sign .sign-line {
        width: 100%;
        height: 0.5px;
        background-color: black;
        margin-block: 2px;
    }
</style>

<body>
    @foreach ($students as $i)     
    
    <div class="a4-page">
        <div class="id-card-container">
            <div>
                <img src="{{ asset('id_card/ID_Card_Front.png') }}" alt="Front Part of ID Card" class="card-img">
                <img src="{{ asset('uploads/students/' . $student->photo) }}" alt="Student's Photo" class="student-photo">
                <p class="student-id">Student</p>

                <div class="student-info">
                    <p><span>Student ID:</span> {{$student->student_id}}</p>
                    <p><span>Name:</span> {{$student->first_name}} {{$student->last_name}}</p>
                    <p><span>Class:</span> {{$student->class_name}}</p>
                    <p><span>Roll:</span> {{$student->roll_number}}</p>
                    <p><span>Blood Group:</span> {{$student->blood}}</p>
                    <p><span>Session:</span> {{$student->session}}</p>
                </div>

                <div class="head-sign">
                    <img src="{{ asset('id_card/signature.png') }}" alt="Sign" >
                    <span class="sign-line"></span>
                    <span>Principal's Signature</span>
                </div>
            </div>
            <img src="{{ asset('id_card/ID_Card_Rear.png') }}" alt="Rear Part of ID Card" class="card-img">

        </div>
    </div>
    @endforeach
</body>
<script>
    $(document).ready(function() {
            window.print();
    });
</script>
</html>