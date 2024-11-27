function validateForm(event) {
    event.preventDefault();  // Prevent default form submission
    let isValid = true;

    // 1. Validate First Name (must be alphabetic and at least 3 characters)
    let firstName = document.forms["contactForm"]["firstname"].value;
    let namePattern = /^[A-Za-z]+$/;
    if (firstName.trim() === "") {
        alert("First name cannot be empty.");
        isValid = false;
    } else if (firstName.length < 3) {
        alert("First name must be at least 3 characters long.");
        isValid = false;
    } else if (!namePattern.test(firstName)) {
        alert("First name must contain only alphabets.");
        isValid = false;
    }

    // 2. Validate Email (must be in a valid email format)
    let email = document.forms["contactForm"]["email"].value;
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        isValid = false;
    }

    // 3. Validate Inquiry Type (must be selected)
    let inquirySelected = false;
    let inquiries = document.forms["contactForm"]["inquiry"];
    for (let i = 0; i < inquiries.length; i++) {
        if (inquiries[i].checked) {
            inquirySelected = true;
            break;
        }
    }
    if (!inquirySelected) {
        alert("Please select an inquiry type.");
        isValid = false;
    }

    // 4. Validate Message (must not be empty)
    let message = document.forms["contactForm"]["message"].value;
    if (message.trim() === "") {
        alert("Message cannot be empty.");
        isValid = false;
    }

    // 5. Validate Email (must be non-empty)
    if (email.trim() === "") {
        alert("Email address cannot be empty.");
        isValid = false;
    }

    // If valid, alert success message and allow form submission
    if (isValid) {
        alert("Form submitted successfully!");
        document.forms["contactForm"].submit();  // Allow form submission
    }
}

window.onload = function() {
    const form = document.forms["contactForm"];
    form.onsubmit = validateForm;
}

function confirmDelete(supplierId) {
  if (confirm('Are you sure you want to delete this supplier?')) {
    // Send request to delete supplier
    fetch(`delete_supplier.php?id=${supplierId}`, {
      method: 'GET'
    })
    .then(response => response.text())
    .then(data => {
      if (data === 'success') {
        // Remove the supplier card from the UI
        document.querySelector(`#supplier-card-${supplierId}`).remove();
        alert('Supplier deleted successfully!');
      } else {
        alert('Error deleting supplier!');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Error deleting supplier!');
    });
  }
}
