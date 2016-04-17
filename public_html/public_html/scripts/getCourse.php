<?php
session_start();
include_once 'connectDB.php';
$q = strval($_GET['q']);
$sql="SELECT * FROM Course WHERE code LIKE '".$q."%'";
$result = mysqli_query($conn,$sql);

echo "<table><thead>
<tr>
<th>Course Code</th>
<th>Course Name</th>
<th>Add Course&nbsp</th>
</tr></thead>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['code'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td><form method=\"post\">
    <button type=\"submit\" name=\"registerCourse\" class=\"btn btn-info\" value=\"".$row['code']."\">Add&nbsp</button>
    </form></td>";
    echo "</tr>";
}
echo "</table>";

?>
