<?php
echo "</main>
      <!-- footer -->
      <footer id='footer'>
        <h1>Database: classicmodels</h1>
        <p>made by 16475762.</p>
    </footer>
    
    <script>
        //when clicked this function will be executed which will submit the button that was clicked
        function work() {
        document.getElementById('form_submit').submit();
        }
        
        function show() {
        let heading = '<h2>Product Line Information</h2>';
        document.getElementbyId('p_description').innerHTML = heading;
        }
    </script>
</body>
</html>";
        ?>