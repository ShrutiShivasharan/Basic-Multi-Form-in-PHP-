<?php
include('./connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi Form</title>
</head>
<style>
    .step { display : none;}
    .active { display : block;}
</style>
<body>
    <div class="container">
        <form id="multiStepForm">
            <!-- step 1 -->
            <div class="step active">
                <h2>Step : 1 - Login Details</h2>
                <label>Email</label>
                <input type="text" id='email' name='email' required>
                <label>Password</label>
                <input type="text" id='password' name='password' required>
            </div>
            <!-- step 2 -->
            <div class="step">
                <h2>Step : 2 - Personal Details</h2>
                <label>Full Name</label>
                <input type="text" id='name' name='name' required>
                <label>Phone Number</label>
                <input type="text" id='phone' name='phone' required>
                <label>Full Address</label>
                <input type="text" id='address' name='address' required>
            </div>
            <!-- step 3 -->
            <div class="step">
                <h2>Step : 3 - Confirmation</h2>
                <p>Review your details before submittion...</p>
                <p><strong>Full Name: <span id="reviewName"></span> </strong></p>
                <p><strong>Email: <span id="reviewEmail"></span> </strong></p>
                <p><strong>Phone: <span id="reviewPhone"></span> </strong></p>
                <p><strong>Full Address: <span id="reviewAddress"></span> </strong></p>
            </div>

            <!-- Buttons -->
            <div class="buttons">
                <button type="button" id="prevBtn" onclick="prevStep()">Previous</button>
                <button type="button" id="nextBtn" onclick="nextStep()">Next</button>
                <button type="submit" id="submitBtn" style="display:none;">Submit</button>
            </div>
        </form>
    </div>


    <script>
        let currentStep = 0;
        const steps = document.querySelectorAll(".step");
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        function showStep(step){
            steps.forEach((s, index) => {
                s.classList.toggle("active", index === step);
            });

            prevBtn.disabled = step === 0;
            nextBtn.style.display = step === steps.length - 1 ? "none" : "inline-block";
            submitBtn.style.display = step === steps.length -1 ? "inline-block" : "none";
        }

        function nextStep() {
            if(!validationsteps()) return;

            if(currentStep < steps.length -1){
                currentStep ++;
                if(currentStep === steps.length - 1) fillReview();
            }
            showStep(currentStep);
        }

        function prevStep(){
           if(currentStep > 0) currentStep--;
           showStep(currentStep);
        }

        function validationsteps(){
            const inputs = steps[currentStep].querySelectorAll("input");
            for(let input of inputs){
                if(!input.value.trim()){
                    alert("Plase fill out all fields");
                    input.focus();
                    return false;
                }
            }
            return true; 
        }

        function fillReview() {
            document.getElementById("reviewName").innerText = document.getElementById("name").value;
            document.getElementById("reviewEmail").innerText = document.getElementById("email").value;
            document.getElementById("reviewPhone").innerText = document.getElementById("phone").value;
            document.getElementById("reviewAddress").innerText = document.getElementById("address").value;
        }

        document.getElementById("multiStepForm").addEventListener("submit", function(event){
            event.preventDefault();

            const fromdata = new FormData();
            fromdata.append("name", document.getElementById("name").value);
            fromdata.append("email", document.getElementById("email").value);
            fromdata.append("password", document.getElementById("password").value);
            fromdata.append("phone", document.getElementById("phone").value);
            fromdata.append("address", document.getElementById("address").value);

            fetch("submitForm.php",{
                method : "POST",
                body:fromdata
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                console.log("response", data);
            })
            .catch(error => console.log("Error while form submit",error))
        });

        showStep(currentStep);
    </script>
</body>
</html>