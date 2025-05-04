 @push("css")
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
 @endpush

 @push("scripts")
     <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
     <script>
         Fancybox.bind("[data-fancybox]", {
             // Your custom options
         });
     </script>
 @endpush
