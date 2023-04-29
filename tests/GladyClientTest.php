<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Wassa\GladyApiClient\GladyClient;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

final class GladyClientTest extends TestCase
{
    private static GladyClient $client;

    public static function setUpBeforeClass(): void
    {
        self::$client = new GladyClient($_ENV['CLIENT_ID'], $_ENV['CLIENT_SECRET'], true);
    }

    public function testBeneficiariesAdd(): string
    {
        $beneficiaryCreateData = [
            "email" => $_ENV['BENEFICIARY_EMAIL_ADD'],
            "language" => "fr_FR",
            "firstName" => "John ",
            "lastName" => "DOE",
            "externalRef" => "0123456789",
            "tags" => ['Tag 1', 'Tag 2'],
            "sendInvitationMail" => true,
        ];

        $res = self::$client->beneficiariesAdd([$beneficiaryCreateData]);
        $this->assertEquals($res->CREATION_SUCCESS[0]->email, $beneficiaryCreateData['email']);

        return $res->CREATION_SUCCESS[0]->id;
    }

    /**
     * @depends testBeneficiariesAdd
     */
    public function testBeneficiariesUpdate(string $id): string
    {
        $beneficiaryUpdateData = [
            "email" => $_ENV['BENEFICIARY_EMAIL_UPDATE'],
            "firstName" => "John bis",
            "lastName" => "DOE bis",
            "externalRef" => "azertyuiop",
            "tags" => ['Tag 1', 'Tag B']
        ];

        $res = self::$client->beneficiariesUpdate($id, $beneficiaryUpdateData);
        $this->assertEquals($res->mail, $beneficiaryUpdateData['email']);

        return $id;
    }

    /**
     * @depends testBeneficiariesAdd
     */
    public function testSsoToken(string $id)
    {
        $res = self::$client->ssoCreateToken([
            'userId' => $id,
            'login' => $_ENV['BENEFICIARY_EMAIL_ADD']
        ]);
        $this->assertMatchesRegularExpression("/^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}$/", $res->token);
    }

    /**
     * @depends testBeneficiariesUpdate
     */
    public function testBeneficiariesDelete(string $id): void
    {
        $res = self::$client->beneficiariesDelete([$id]);
        $this->assertEquals($res->DELETION_SUCCESS[0]->beneficiaryId, $id);
    }
}

//var_dump($client->ssoCreateToken(["login" => "john.walter+test@wassa.io"]));
//var_dump($client->beneficiariesGetById("e6d24223-90e4-4dfa-b90a-ad52e57083f1"));
//var_dump($client->beneficiariesGetByLogin("john.walter+test@wassa.io"));
//var_dump($client->beneficiariesGetBalance("e6d24223-90e4-4dfa-b90a-ad52e57083f1"));
// var_dump($client->beneficiariesList([
//   "invited" => false,
//   "pageSize" => 10,
//   "pageIndex" => 0
// ]));

// var_dump($client->beneficiariesUpdate("0c2a4b65-29d9-4fa0-b190-f035193d396f", [
//   "email" => "jo.walt+2xxxx@gmail.com",
//   "language" => "fr_FR",
//   "firstName" => "John bis",
//   "lastName" => "DOE bis",
//   "externalRef" => "0123456789",
//   "tags" => ['Content' ,'Pas content'],
//   "login" => "jo.walt+xxxx@gmail.com",
// ]));
//var_dump($client->beneficiariesDelete(["0c2a4b65-29d9-4fa0-b190-f035193d396f", "146ad482-932b-4d8c-8f54-e6644b429ab1"]));
//var_dump($client->walletsList());
// var_dump($client->walletsCreateReason([
//   "walletId" => 1,
//   "titles" => [
//     "FRENCH" => "Raison de test 2",
//     "ENGLISH" => "Test reason 2",
//     "DUTCH" => "??? 2",
//   ]
// ]));
// var_dump($client->walletsUpdateReason(9353, [
//     "FRENCH" => "Raison de test 2bis",
//     "ENGLISH" => "Test reason 2bis",
//     "DUTCH" => "??? 2bis",
//   ]));
//var_dump($client->walletsDeleteReason(9353));
//var_dump($client->organisationsListDeposits());
//var_dump($client->organisationsGetDeposit("168e05db-ec61-468a-8a1f-52f77f133a94"));
// var_dump($client->campaignsCreate([
//   "reasonId" => 9187,
//     "depositId" => "168e05db-ec61-468a-8a1f-52f77f133a94",
//     "distributions" => [
//       [
//         "beneficiaryId" => "e6d24223-90e4-4dfa-b90a-ad52e57083f1",
//         "amount" => [
//           "currency" => "EUR",
//           "value" => "100.53",
//         ],
//       ],
//     ],
//     "message" => "Test de distribution",
//   ]));