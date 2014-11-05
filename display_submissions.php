<?php
	$sub_tr = '';
	$std_id_get = '';
	if ( ( $_SESSION['dropofftype'] == 'Admin' || 
			   $_SESSION['dropofftype'] == 'Instructor' ) && 
			   is_numeric($_GET['uid']) ) {
			$sub = DOSubmission::getDOSubmissions($_GET['uid']);
			$std_id_get = "&uid=".$_GET['uid'];
			while( $row = mysql_fetch_array($sub) ) {
				$sgrade[$row['letter_grade']] = ' selected="true"';
				$sub_tr .= "<form method=\"post\" name=\"sub$row[sid]\" action=\"$_SERVER[PHP_SELF]?uid=$_GET[uid]\">
											<input type=\"hidden\" name=\"sid\" value=\"$row[sid]\" />
											<input type=\"hidden\" name=\"task\" value=\"submit_feedback\" />
											<tr><td>$row[project_title]</td><td>$row[description]</td><td>$row[project_text]</td><td><a href=\"$row[project_url]\">$row[project_url]</a></td><td>$row[project_file]</td><td>
											<textarea name=\"feedback\">$row[feedback]</textarea>
											</td><td>
											<select name=\"letter_grade\">
												<option value=\"\">--</option>
												<option value=\"A\"$sgrade[A]>A</option>
												<option value=\"Am\"$sgrade[Am]>A-</option>
												<option value=\"Bp\"$sgrade[Bp]>B+</option>
												<option value=\"B\"$sgrade[B]>B</option>
												<option value=\"Bm\"$sgrade[Bm]>B-</option>
												<option value=\"Cp\"$sgrade[Cp]>C+</option>
												<option value=\"C\"$sgrade[C]>C</option>
												<option value=\"Cm\"$sgrade[Cm]>C-</option>
												<option value=\"Dp\"$sgrade[Dp]>D+</option>
												<option value=\"D\"$sgrade[D]>D</option>
												<option value=\"Dm\"$sgrade[Dm]>D-</option>
												<option value=\"F\"$sgrade[F]>F</option>
											</select></td>
											<td><input type=\"number\" name=\"points_earned\" value=\"$row[points_earned]\" /></td><td>$row[submit_date]</td><td><input type=\"submit\" /></td></tr>
											</form>\n";
				unset($sgrade);
			}
	}
	else {
			$sub = DOSubmission::getDOSubmissions($user_id);
			while( $row = mysql_fetch_array($sub) ) {
				$sgrade[$row['letter_grade']] = ' selected="true"';
				$sub_tr .= "<tr><td>$row[project_title]</td><td>$row[description]</td><td>$row[project_text]</td><td><a href=\"$row[project_url]\">$row[project_url]</a></td><td>$row[project_file]</td><td>
											$row[feedback]
											</td><td>
											<select name=\"letter_grade\">
												<option value=\"\">--</option>
												<option value=\"A\"$sgrade[A]>A</option>
												<option value=\"Am\"$sgrade[Am]>A-</option>
												<option value=\"Bp\"$sgrade[Bp]>B+</option>
												<option value=\"B\"$sgrade[B]>B</option>
												<option value=\"Bm\"$sgrade[Bm]>B-</option>
												<option value=\"Cp\"$sgrade[Cp]>C+</option>
												<option value=\"C\"$sgrade[C]>C</option>
												<option value=\"Cm\"$sgrade[Cm]>C-</option>
												<option value=\"Dp\"$sgrade[Dp]>D+</option>
												<option value=\"D\"$sgrade[D]>D</option>
												<option value=\"Dm\"$sgrade[Dm]>D-</option>
												<option value=\"F\"$sgrade[F]>F</option>
											</select></td>
											<td>$row[points_earned]</td><td>$row[submit_date]</td></tr>
											\n";
			}
	}	
