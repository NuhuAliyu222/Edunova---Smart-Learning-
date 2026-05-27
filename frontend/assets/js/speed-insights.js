// Vercel Speed Insights Integration
// This script initializes Vercel Speed Insights for performance monitoring

(function() {
  // Initialize Speed Insights window object
  window.si = window.si || function () {
    (window.siq = window.siq || []).push(arguments);
  };

  // Load the Speed Insights script
  const script = document.createElement('script');
  script.defer = true;
  script.src = '/_vercel/speed-insights/script.js';
  
  // Insert script into document head
  const firstScript = document.getElementsByTagName('script')[0];
  if (firstScript && firstScript.parentNode) {
    firstScript.parentNode.insertBefore(script, firstScript);
  } else {
    document.head.appendChild(script);
  }
})();
