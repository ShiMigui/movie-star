const $alert = document.getElementById('alert');

if ($alert) {
  const rect = $alert.getBoundingClientRect();
  const isVisible = (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );

  if (!isVisible) $alert.scrollIntoView({ behavior: 'smooth' });
}