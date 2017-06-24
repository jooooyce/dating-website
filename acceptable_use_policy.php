<?php
/*
Group09: Ellen Coombs, Will Beniuk, Andrew Daigneault & Yina Qin
September 27, 2015
WEDE3201
*/

$title = "Welcome Back!";
$date = "2015-09-27";
$filename = "dashboard.php";
$banner = "Welcome Back to NerdLink!";
$description = "This page serves as the dashboard once a user correctly logs in.";
//session_start();
include ("header.php");
include ("secure-navbar.php");
include_once("includes/db.php");
$disabledMessage = "";
if (isset($_SESSION['disabledMessage']))
{
    $disabledMessage ="<script language=\"javascript\"> alert(\"Your account has been disabled for having inappropriate or offensive material. Please read the Acceptable Use Policy.\")</script>";
    unset($_SESSION['disableMessage']);
    session_destroy();
    session_start();
}
?>


<center>
    <br/><br/><h3>Acceptable Use Policy</h3>
    <p><br/>
        <br/>This Acceptable Use Policy document, including the following list of Prohibited Activities, is an integral part of your Hosting Agreement with NerdLink. If you engage in any of the activities prohibited by this AUP document NerdLink may suspend or terminate your account.

        NerdLink's Acceptable Use Policy (the "Policy") for NerdLink Services is designed to help protect NerdLink, NerdLink's customers and the Internet community in general from irresponsible or, in some cases, illegal activities. The Policy is a non-exclusive list of the actions prohibited by NerdLink. NerdLink reserves the right to modify the Policy at any time, effective upon posting at http://url_to_AUP_policy.

        <br/><br/>Prohibited Uses of NerdLink Systems and Services:

        <br/><br/>1. Transmission, distribution or storage of any material in violation of any applicable law or regulation is prohibited. This includes, without limitation, material protected by copyright, trademark, trade secret or other intellectual property right used without proper authorization, and material that is obscene, defamatory, constitutes an illegal threat, or violates export control laws.

        <br/><br/>2. Sending Unsolicited Bulk Email ("UBE", "spam"). The sending of any form of Unsolicited Bulk Email through NerdLink's servers is prohibited. Likewise, the sending of UBE from another service provider advertizing a web site, email address or utilizing any resource hosted on NerdLink's servers, is prohibited. NerdLink accounts or services may not be used to solicit customers from, or collect replies to, messages sent from another Internet Service Provider where those messages violate this Policy or that of the other provider.

        <br/><br/>3. Running Unconfirmed Mailing Lists. Subscribing email addresses to any mailing list without the express and verifiable permission of the email address owner is prohibited. All mailing lists run by NerdLink customers must be Closed-loop ("Confirmed Opt-in"). The subscription confirmation message received from each address owner must be kept on file for the duration of the existence of the mailing list. Purchasing lists of email addresses from 3rd parties for mailing to from any NerdLink-hosted domain, or referencing any NerdLink account, is prohibited.

        <br/><br/>4. Advertising, transmitting, or otherwise making available any software, program, product, or service that is designed to violate this AUP or the AUP of any other Internet Service Provider, which includes, but is not limited to, the facilitation of the means to send Unsolicited Bulk Email, initiation of pinging, flooding, mail-bombing, denial of service attacks.

        <br/><br/>5. Operating an account on behalf of, or in connection with, or reselling any service to, persons or firms listed in the Spamhaus Register of Known Spam Operations (ROKSO) database at www.spamhaus.org/rokso.

        <br/><br/>6. Unauthorized attempts by a user to gain access to any account or computer resource not belonging to that user (e.g., "cracking").

        <br/><br/>7. Obtaining or attempting to obtain service by any means or device with intent to avoid payment.

        <br/><br/>8. Unauthorized access, alteration, destruction, or any attempt thereof, of any information of any NerdLink customers or end-users by any means or device.

        <br/><br/>9. Knowingly engage in any activities designed to harass, or that will cause a denial-of-service (e.g., synchronized number sequence attacks) to any other user whether on the NerdLink network or on another provider's network.

        <br/><br/>10. Using NerdLink's Services to interfere with the use of the NerdLink network by other customers or authorized users.


        <br/><br/>Customer Responsibility for Customer's Users

        <br/><br/>Each NerdLink customer is responsible for the activities of its users and, by accepting service from NerdLink, is agreeing to ensure that its customers/representatives or end-users abide by this Policy. Complaints about customers/representatives or end-users of an NerdLink customer will be forwarded to the NerdLink customer's postmaster for action. If violations of the NerdLink Acceptable Use Policy occur, NerdLink reserves the right to terminate services with or take action to stop the offending customer from violating NerdLink's AUP as NerdLink deems appropriate, without notice.

        <br/><br/>Last Modified: Sat, 05 Dec 15 06:43:45 +0000
        <br/><br/>
        <a href="index.php">Return To Index</a>
    </p></center>
 
 
    <!--LOGIN BOX CODE-->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="loginmodal-container">
            <h2>Login to Your Account</h2><br/>
            <form action="./login.php" method="post">
                <p><input type="text" name="login" value="<?php echo $login; ?>" placeholder="Username"/></p>
                <p><input type="password" name="pass" placeholder="Password"/></p>
				<div class="login-help">
					<a href="user-password-request.php">Forgot Password</a>
				</div><br />
                <p><input type="submit" name="signin" class="login loginmodal-submit" value="Sign In"/></p>
            </form>

        </div>
    </div>
</div>
    <?php echo $disabledMessage; ?>
<?php include ("footer.php");?>