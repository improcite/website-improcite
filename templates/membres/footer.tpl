<script src="/vendor/components/jquery/jquery.min.js"></script>
<script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="/vendor/datatables.net/datatables.net/js/dataTables.min.js"></script>
<script src="/vendor/datatables.net/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/js/membres.js"></script>
<script>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
$('[id^="table-"]').DataTable({
  language: { url: '/assets/langs/fr-FR.json' },
  order: [[0, 'desc']]
});
</script>
</body>
</html>
