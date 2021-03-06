<?php
$cxn = new mysqli("warehouse.cims.nyu.edu", "nc1345", "dx3mjzbx", "nc1345_my_database");
//$query = "SELECT * FROM SAT_Results ORDER BY TestTakers";

$queryInfo="SHOW COLUMNS FROM SAT_Results";
$resultInfo=$cxn->query($queryInfo);

$query1 = "SELECT COUNT(*) as count FROM SAT_Results";
$query2 = "SELECT * FROM SAT_Results ORDER BY TestTakers DESC limit 0,10";
$query3 = "SELECT School, Math, Reading, Writing FROM SAT_Results ORDER BY School ASC limit 0,10";
$query4 = "SELECT School, (AVG(Math)+ AVG(Reading)+ AVG(Writing))/3 as Average FROM SAT_Results GROUP BY School DESC limit 0,10";
$query5 = "SELECT * FROM SAT_Results ORDER BY School ASC limit 0,15";
$query6 = "SELECT * FROM SAT_Results ORDER BY Reading DESC limit 0,10";
$query7 = "SELECT * FROM SAT_Results ORDER BY Writing DESC limit 0,10";
$query8 = "SELECT * FROM SAT_Results ORDER BY Math DESC limit 0,10";
$query9 = "SELECT * FROM SAT_Results WHERE Math > 500 ORDER BY TestTakers ASC limit 0,10";
$query10 = "SELECT * FROM SAT_Results WHERE Writing >500 ORDER BY TestTakers ASC limit 0,10";
//$result = $cxn->query($query);
$result1 = $cxn->query($query1); 
$result2 = $cxn->query($query2); 
$result3 = $cxn->query($query3); 
$result4 = $cxn->query($query4); 
$result5 = $cxn->query($query5); 
$result6 = $cxn->query($query6); 
$result7 = $cxn->query($query7); 
$result8 = $cxn->query($query8); 
$result9 = $cxn->query($query9); 
$result10 = $cxn->query($query10); 
?>

<!DOCTYPE html>
<!--P1 TAG p class = "p1" -->
<html lang ="en">
	<head>
		<style type="text/css">
body {
	background-color: #CEDADE;
	margin:0px;
	padding:0px;
	height:100%;
}
p {
	color:#61696B;
	font-size: 13px;
}
h4 {color:#83878A;}
#wrapper{
	min-height: 10%;
	width: 100%;
	position: relative;
}
#header {
	background-color:#C5C6C7;
	height: 100px;
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	text-align: center;
}
#sectionWrapper{
	background-color:#CEDADE;
	margin-top:10px;
	position: relative;
}
#sidebar {
	background-color:#CFCFCF;
	height:100%;
	width:100px;
	float: left;
	position: fixed;
	padding-left: 10px;
	padding-top: 10px;
}
#rightSidebar{
	background-color:#CEDADE;
	height:100%;
	width:100px;
	float: right;
	position: fixed;
	right:0px;
}
#textBody{
	background-color:#CEDADE;
	width: 100%;
	height:100%;
	float: center;
	margin-top: 10px;
	padding-top: 10px;
	padding-left:20px;
	padding-bottom: 800px;
	overflow: scroll;
	overflow-x: hidden;
}
#footerWrapper{
	background-color:#CEDADE;
	position: :relative;
	min-height: 100%;
}
#footer {
	background-color:#C3C6C7;
	position:fixed;
	bottom:0px;
	left:0px;
	width:100%;
	height:70px;
	text-align: center;	
}
a:link {
	color:#61696B;
	background-color: transparent;
	text-decoration: none;
}
a:visited {
	color:#484A4A;
	background-color: transparent;
	text-decoration: none;
}
a:hover {
	color:#CEDADE;
	background-color: transparent;
	text-decoration: underline;
}
a:active {
	color:#61696B;
	background-color: transparent;
	text-decoration: none;
}
table{
	margin-left: 20%;
}
</style>
		<meta charset ="utf-8">
		<title> SAT Results </title>

</head>
<body>
	<div class= "wrapper">
		<div id = "header">
			<h1>SAT Results</h1>
			<div id="sectionWrapper"></div>
			<div id="sidebar">
				<h4> <a href= "http://i6.cims.nyu.edu/~nc1345/ASSIGNMENT1.html">Home</a> </h4>
				<h4> Assignments </h4>
				<p> <a href= "http://i6.cims.nyu.edu/~nc1345/Assignment1_Part2.html">Assignment 1 </a> <br></p>
				<p> <a href ="http://i6.cims.nyu.edu/~nc1345/Assignment3.php"> Assignment 3</a></p>
			</div>
			<div id="textBody">
				<?php if ($cxn->error): ?>
					<p class ="error">
					Query syntax error!
					<?php print($cxn -> error);?>
					</p>
					<?php endif; ?>
					<!-- subheading for table structures?? refix-->
				<p>The data is of all NYC public schools and their corresponding SAT Scores. 
					It also includes the number of test takers for each school
					If there is a 0 in any of the data fields, it means that there was
					no data corresponding with that field. The data is interesting because
					it allows us to see the highest peforming schools in NYC. It also
					allows us to see which school scored highest in certain categories.</p>
				<p>Fields in MYSQL table and their data type. The original data can be found
					<a href= "https://nycopendata.socrata.com/Education/SAT-Results/f9bf-2cp4"> here </a> </p>
				<table style ="width: 50%">
					<tr>
						<th>School</th>
						<th>Reading</th>
						<th>Math</th>
						<th>Writing</th>
					</tr>	
					<?php while ($row = mysqli_fetch_array($resultInfo)){
						 echo
							'<tr>
								<td><p>'.$row['Field'].'</p></td>
								<td><p>'.$row['Type'].'</p></td>
								<td><p>'.$row['Null'].'</p></td>
								<td><p>'.$row['Key'].'</p></td>
							</tr>';
						}
						echo
						'</table>';
						?>
				<p>Justification: All testakers and scores are integers. School names were strings. All were nulled before.</p>

				<h4> 1 <h4>
					<p>This is the total number of schools.</p>
						<?php $count= $result1->fetch_assoc();
								print ($count['count']);?>

				<h4> 2 <h4>
					<p>The top 10 schools with the most test takers.</p>
						<?php while ($row = $result2->fetch_assoc()): ?>
							<article>
						<p><?php $school=$row['School'];
								 $TestTakers=$row['TestTakers'];
								 printf("%s %s",$school, $TestTakers); ?></p>

							</article>
						<?php endwhile; ?>
				<h4> 3 <h4>
					<p>The 10 schools with the highest test scores.</p>
					<table style ="width: 50%">
						<tr>
							<th>School</th>
							<th>Reading</th>
							<th>Math</th>
							<th>Writing</th>
						</tr>			
						<p><?php while ($row = $result3->fetch_assoc()){
							 echo
								'<tr>
									<td><p>'.$row['School'].'</p></td>
									<td><p>'.$row['Reading'].'</p></td>
									<td><p>'.$row['Math'].'</p></td>
									<td><p>'.$row['Writing'].'</p></td>
								</tr>';
							}
							echo
							'</table>';
							?>

				<h4> 4 <h4>
					<p>The average of the 3 test scores of 10 schools.</p>
					<table style ="width: 50%">
						<tr>
							<th>School</th>
							<th>Average</th>
						</tr>
					<?php while($row=$result4->fetch_assoc()){
						echo 
						'<tr>
							<td><p>'.$row['School'].'</p></td>
							<td><p>'.$row['Average'].'</p></td>
						</tr>';
					}
					echo
					'</table>';
					?>
				<h4> 5 <h4>
					<p>First 15 records, alphabetically.</p>
					<table style ="width: 50%">
						<tr>
							<th>School</th>
							<th>Reading</th>
							<th>Math</th>
							<th>Writing</th>
						</tr>	
					<p><?php while ($row = $result5->fetch_assoc()){
						 echo
							'<tr>
								<td><p>'.$row['School'].'</p></td>
								<td><p>'.$row['Reading'].'</p></td>
								<td><p>'.$row['Math'].'</p></td>
								<td><p>'.$row['Writing'].'</p></td>
							</tr>';
						}
						echo
						'</table>';
							?>

				<h4> 6 <h4>
					<p>10 Highest Reading Score</p>
						<table style ="width: 50%">
						<tr>
							<th>School</th>
							<th>Reading</th>
							<th>Math</th>
							<th>Writing</th>
						</tr>	
					<p><?php while ($row = $result6->fetch_assoc()){
						 echo
							'<tr>
								<td><p>'.$row['School'].'</p></td>
								<td><p>'.$row['Reading'].'</p></td>
								<td><p>'.$row['Math'].'</p></td>
								<td><p>'.$row['Writing'].'</p></td>
							</tr>';
						}
						echo
						'</table>';
							?>

				<h4> 7 <h4>
					<p>10 Highest Writing Score</p>
					<table style ="width: 50%">
						<tr>
							<th>School</th>
							<th>Writing</th>
							<th>Math</th>
							<th>Reading</th>
						</tr>	
					<p><?php while ($row = $result7->fetch_assoc()){
						 echo
							'<tr>
								<td><p>'.$row['School'].'</p></td>
								<td><p>'.$row['Writing'].'</p></td>
								<td><p>'.$row['Math'].'</p></td>
								<td><p>'.$row['Reading'].'</p></td>
							</tr>';
						}
						echo
						'</table>';
							?>
				<h4> 8 <h4>
					<p>10 Highest Math Score</p>
					<table style ="width: 50%">
						<tr>
							<th>School</th>
							<th>Math</th>
							<th>Reading</th>
							<th>Writing</th>
						</tr>	
					<p><?php while ($row = $result8->fetch_assoc()){
						 echo
							'<tr>
								<td><p>'.$row['School'].'</p></td>
								<td><p>'.$row['Math'].'</p></td>
								<td><p>'.$row['Reading'].'</p></td>
								<td><p>'.$row['Writing'].'</p></td>
							</tr>';
						}
						echo
						'</table>';
							?>
				<h4> 9 <h4>
					<p>10 Math Scores Above 500</p>
						<table style ="width: 50%">
						<tr>
							<th>School</th>
							<th>Math</th>
							<th>Reading</th>
							<th>Writing</th>
						</tr>	
					<p><?php while ($row = $result9->fetch_assoc()){
						 echo
							'<tr>
								<td><p>'.$row['School'].'</p></td>
								<td><p>'.$row['Math'].'</p></td>
								<td><p>'.$row['Reading'].'</p></td>
								<td><p>'.$row['Writing'].'</p></td>
							</tr>';
						}
						echo
						'</table>';
							?>
				<h4> 10 <h4>
					<p>10 Writing Scores Above 500</p>
						<table style ="width: 50%">
						<tr>
							<th>School</th>
							<th>Writing</th>
							<th>Math</th>
							<th>Reading</th>
						</tr>	
					<p><?php while ($row = $result10->fetch_assoc()){
						 echo
							'<tr>
								<td><p>'.$row['School'].'</p></td>
								<td><p>'.$row['Writing'].'</p></td>
								<td><p>'.$row['Reading'].'</p></td>
								<td><p>'.$row['Math'].'</p></td>
								
							</tr>';
						}
						echo
						'</table>';
							?>

				</div>
		<div class ="footerWrapper"></div>
			<div id="footer"></div>
		</div> //textBody
	</body>
</html>
