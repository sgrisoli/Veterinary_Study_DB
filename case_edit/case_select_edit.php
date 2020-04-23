<html>
<head>
    <title>Select Case</title>
    <a href="../index.php">Back To Home</a>
<head>

<body>
    <!-- Form to select case and field -->
    <form action='case_edit.php' method='POST' id="edit_form">
        <p>Case Number: <input type='number' name='case_num'></p>
        <p>Field to Modify:
            <select name='update_select' id='update_select' onmouseup="input_select()">
                <option value=name>Name</option>
                <option value=species>Species</option>
                <option value=breed>Breed</option>
                <option value=sex>Sex</option>
                <option value=age>Age</option>
                <option value=weight>Weight</option>
                <option value=chip_num>Chip Number</option>
                <option value=symptoms>Symptoms</option>
                <option value=diagnosis>Diagnosis</option>
                <option value=treatment>Treatment</option>
                <option value=drug>Drug</option>
            </select>
        </p>
        <button id='update_button' type='submit' value='submit'>Submit</button>
    </form>
<p>test</p>
        

</body>


</html>