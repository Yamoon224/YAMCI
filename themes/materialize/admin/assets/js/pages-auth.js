/* pages-auth.js — Pixinvent template stub for auth pages
 * The original Pixinvent pages-auth.js initializes FormValidation on
 * #formAuthentication / #registerForm / #formResetPassword. SMA's auth views
 * use plain HTML5 required attributes for client-side validation and CI
 * server-side validation, so this stub is enough.
 *
 * This file exists to silence the SyntaxError("Unexpected token '<'") caused
 * by CodeIgniter's catch-all route 307-redirecting missing assets to '/'.
 */
(function () {
  'use strict';

  // Surface the form-validation library to existing inline handlers if any.
  if (typeof FormValidation !== 'undefined' && document.getElementById('formAuthentication')) {
    // No-op: SMA relies on browser HTML5 validation + server-side rules.
  }
})();
