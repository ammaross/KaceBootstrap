<h2>All Open Tickets</h2>
<table class="table table-striped table-bordered table-head-bordered-bottom table-condensed">
  <thead>
    <tr>
      <th class=span1>Ticket ID</th>
      <th class=span2>Title</th>
      <th class=span2>Submitter</th>
      <th class=span2>Owner</th>
      <th class=span1>Created</th>
      <th class=span1>Modified</th>
    </tr>
  </thead>
  <tbody>

<?php

$query1 = "
SELECT HD_TICKET.ID as ID, 
HD_TICKET.TITLE as Title, 
HD_STATUS.NAME AS Status, 
HD_PRIORITY.NAME AS Priority, 
HD_TICKET.CREATED as Created, 
HD_TICKET.MODIFIED as Modified, 
S.FULL_NAME  as Submitter, 
O.FULL_NAME  as Owner, 
HD_TICKET.CUSTOM_FIELD_VALUE0 as Type  
FROM HD_TICKET  
JOIN HD_STATUS ON (HD_STATUS.ID = HD_TICKET.HD_STATUS_ID) 
JOIN HD_PRIORITY ON (HD_PRIORITY.ID = HD_TICKET.HD_PRIORITY_ID) 
LEFT JOIN USER S ON (S.ID = HD_TICKET.SUBMITTER_ID) 
LEFT JOIN USER O ON (O.ID = HD_TICKET.OWNER_ID) 
WHERE (HD_TICKET.HD_QUEUE_ID = $mainQueueID) AND 
(HD_STATUS.STATE not like '%Closed%')  
ORDER BY Owner, Created DESC
";


$result1 = mysql_query($query1);
$num = mysql_numrows($result1);
$i = 0;
while ($i < $num)
{
	$ID = mysql_result($result1,$i,"ID");
	$Title = mysql_result($result1,$i,"Title");
	$Status = mysql_result($result1,$i,"Status");        
	$Type = mysql_result($result1,$i,"Type");
	$Created = mysql_result($result1,$i,"Created");
	$Modified = mysql_result($result1,$i,"Modified");
	$Priority = mysql_result($result1,$i,"Priority");
	$Owner = mysql_result($result1,$i,"Owner");	
	$Submitter = mysql_result($result1,$i,"Submitter");

	$ID = stripslashes($ID);
	$Title = stripslashes($Title);
	$Status = stripslashes($Status);
	$Type = stripslashes($Type);
	$Created = stripslashes($Created);	
	$Modified = stripslashes($Modified);
	$Priority = stripslashes($Priority);
	$Owner = stripslashes($Owner);
	$Submitter = stripslashes($Submitter);


	$StatusSpan="";
	if ($Status=="Stalled")
	{
		$StatusSpan="<span class='label label-warning'>$Status</span>";
	}

	$PriortySpan="";
	if ($Priority=="High")
	{
		$PriortySpan="<span class='label label-important'><i class='icon-exclamation-sign icon-white'></i>High</span>";
	}

	if ($Priority=="Low")
	{
		$PriortySpan="<span class='label'>Low</span>";
	}

	echo "<tr><td><a href='http://$KaceBoxDNS/adminui/ticket.php?ID=$ID' target='_blank'>$ID</a> $StatusSpan $PriortySpan</td> \n";
	echo "<td>$Title</td> \n";
	echo "<td>$Submitter</td> \n";
	echo "<td>$Owner</td> \n";
	echo "<td>$Created</td> \n";
	echo "<td>$Modified</td> \n";
	echo "</tr> \n";
	$i++;
}

echo "</tbody></table> \n";
?>
