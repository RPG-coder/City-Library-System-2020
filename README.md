<h1 text-align="center">City-Library-System-2020</h1>
<p>A full-fledge City Library system for a Librarian</p>

<ul><h2>Features</h2>
  <li><ul>General
        <li>Easy to use GUI</li>
      </ul>
      <br/>
  </li>
  <li>
    <ul>Reader's Functions
      <li><em>Add to Cart</em> Functionality</li>
      <li>Borrow (single documents/ multiple documents)</li>
      <li>Reserve (single documents/ multiple documents)</li>
      <li>Return (single documents/ multiple documents)</li>
      <li>Search Documents by Document's name or by the Publisher's name </li>
      <li>Automatic Fine setting (Default Due-date: 20 days from document borrow date for each borrowed document)</li>
      <li>Automatic Deletion of Reserved Document (Default: by 6PM / at Library close time every day)</li>
      <li>Max Limit for Borrowing documents (Default: 10 documents per reader)</li>
    </ul>
    <br/>
  </li>
  
  <li>
    <ul>Admin's Functions
      <li>Add new Readers</li>
      <li>Add new Documents / Copies</li>
      <li>View all Library Branches (if any)</li>
      <li>
        <ul>Miscellaneous
          <li> Taking Library Branch number and get the most popular book at the moment</li>
          <li> Taking Library Branch number and get the active reader for that libranch branch</li>
          <li> Most popular books of a given year</li>
          <li> Average Fine paid by the borrowers from in a given interval date</li>
        </ul>
      </li>
    </ul>
    <br/>
  </li>
</ul>

<ul><h2>Installation Guide</h2>
  <li>
    <ul list-style-type: lower-alpha>Steps
      <li>Install Xampp: https://www.apachefriends.org/index.html</li>
      <li>
        Place the Frontend folder htdoc*: <em>$INSTALL_PATH\xampp\htdocs</em><br/>
        Run Apache in XAMPP and then open a browser enter url address as, <em>localhost/Frontend/</em>, to view the app.
      </li>
      <li>Open MySQL Admin: <br>
        <ul>Steps:
          <li>1. `$ mysql -u root -p`</li>
          <li>2. Then we need to give access like this:<br/>
             <code>
               `mysql> SET GLOBAL local_infile = true;`<br/>
               `mysql> exit`
            </code>
          </li>
          <li>3. Command to use to populate database:<br/>
             <code>`$ mysql --local-infile=1 -u root -p < initialize.sql`</code>
          </li>
        </ul>
      </li>
    </ul> <br/>
    <em>$INSTALL_PATH = the path where XAMPP files are located*</em>
  </li>
</ul>
<hr/>
<h3 align="center">HAPPY USING</h3>
