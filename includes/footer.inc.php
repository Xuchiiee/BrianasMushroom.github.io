
</tr>
</table>
</head>
<body>
<button id="btnGoogle">Messenger</button>
</body>
<script>
      let other = null; 
      let features =
        'menubar=no,location=no,resizable=no,scrollbars=yes,status=no,height=700,width=550';

      document.getElementById('btnGoogle').addEventListener('click', (ev) => {
        let url = '../chatting';
        let other = window.open(url, '_blank', features);
      });
        
</script>
<footer>Supply Chain Management for Briana's mushroom products.</footer>