/**
 * DevPortfolio - Interactive Client-Side JavaScript
 * 
 * Handles navigation scroll effects, client-side validation, 
 * confirmation prompts, and admin modals.
 * 
 * Course: Advanced Web Development in PHP (Assignment 2)
 */

document.addEventListener('DOMContentLoaded', () => {
  'use strict';

  // 1. Sticky Navbar background blur on scroll
  const navbar = document.querySelector('.navbar-custom');
  if (navbar) {
    const handleScroll = () => {
      if (window.scrollY > 40) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    };
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
  }

  // 2. Client-side Form Validation (Bootstrap 5 pattern)
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach((form) => {
    form.addEventListener(
      'submit',
      (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      },
      false
    );
  });

  // 3. Contact Form Real-Time Validation Feedback
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    const emailInput = contactForm.querySelector('#email');
    const messageInput = contactForm.querySelector('#message');

    if (emailInput) {
      emailInput.addEventListener('input', () => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailInput.value.trim() !== '' && !emailRegex.test(emailInput.value)) {
          emailInput.setCustomValidity('Please provide a valid email address.');
        } else {
          emailInput.setCustomValidity('');
        }
      });
    }

    if (messageInput) {
      messageInput.addEventListener('input', () => {
        if (messageInput.value.trim().length < 10) {
          messageInput.setCustomValidity('Message must be at least 10 characters long.');
        } else {
          messageInput.setCustomValidity('');
        }
      });
    }
  }

  // 4. Auto-dismiss alerts after 7 seconds
  const autoDismissAlerts = document.querySelectorAll('.alert-dismissible');
  autoDismissAlerts.forEach((alertEl) => {
    setTimeout(() => {
      try {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
        if (bsAlert) {
          bsAlert.close();
        }
      } catch (e) {
        // Fallback dismiss
        alertEl.style.display = 'none';
      }
    }, 7000);
  });

  // 5. Admin Message Modal Populator
  const viewMessageModal = document.getElementById('viewMessageModal');
  if (viewMessageModal) {
    viewMessageModal.addEventListener('show.bs.modal', (event) => {
      const button = event.relatedTarget;
      if (!button) return;

      const name = button.getAttribute('data-name') || '';
      const email = button.getAttribute('data-email') || '';
      const subject = button.getAttribute('data-subject') || '';
      const message = button.getAttribute('data-message') || '';
      const date = button.getAttribute('data-date') || '';
      const id = button.getAttribute('data-id') || '';

      const modalName = viewMessageModal.querySelector('#modalMsgSender');
      const modalEmail = viewMessageModal.querySelector('#modalMsgEmail');
      const modalSubject = viewMessageModal.querySelector('#modalMsgSubject');
      const modalContent = viewMessageModal.querySelector('#modalMsgContent');
      const modalDate = viewMessageModal.querySelector('#modalMsgDate');

      if (modalName) modalName.textContent = name;
      if (modalEmail) {
        modalEmail.textContent = email;
        modalEmail.href = `mailto:${email}?subject=Re: ${encodeURIComponent(subject)}`;
      }
      if (modalSubject) modalSubject.textContent = subject;
      if (modalContent) modalContent.textContent = message;
      if (modalDate) modalDate.textContent = date;
    });
  }

  // 6. Generic Confirmation Dialog Helper
  window.confirmAction = (message, formId) => {
    if (confirm(message)) {
      const form = document.getElementById(formId);
      if (form) {
        form.submit();
      }
      return true;
    }
    return false;
  };
});
