<?php
error_reporting(E_ALL);

class DBX {
    protected PDO $conn;
    public int $MAXemail = 40;
    public int $MAXcomment = 21;
    public int $pageSize = 20;
    public int $donationPosition = 10;
    public int $subNum;
    public float $pagesCount;

    public array $statCols = [
        0 => "invitation", 1 => "domestic", 2 => "foreign", 3 => "press", 4 => "foundation",
        5 => "institution", 6 => "academic", 7 => "emailList", 8 => "returnedMail",
        9 => "feedbackBook", 10 => "juror", 11 => "juror_past", 12 => "curator",
        13 => "artist", 14 => "resident", 15 => "residentRecommender", 16 => "publication",
        17 => "programList", 18 => "otherList", 19 => "individual", 20 => "corporate",
        21 => "USgoverment", 22 => "foreignAgency", 23 => "res_contact", 24 => "conference"
    ];

    public array $statNames = [
        0 => "invitation", 1 => "domestic", 2 => "foreign", 3 => "press", 4 => "foundation",
        5 => "institution", 6 => "academic", 7 => "email", 8 => "returned mail",
        9 => "feedback/Book", 10 => "juror", 11 => "past juror", 12 => "curator",
        13 => "artist", 14 => "fellow", 15 => "fellow-recommender", 16 => "publication",
        17 => "program", 18 => "other", 19 => "individual", 20 => "corporate",
        21 => "US goverment", 22 => "foreign agency", 23 => "res_contact", 24 => "conference"
    ];

    public function __construct() {
        $dbhost = 'localhost';
        $dbuser = 'apexart291';
        $dbpass = 'love2php!';
        $dbname = 'ODB-apexart';

        try {
            $this->conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    protected function checkError($stmt): void {
        if (!$stmt) {
            $error = $this->conn->errorInfo();
            die("Query failed: " . $error[2]);
        }
    }

    public function Login(string $username, string $password): ?array {
        if (empty($username)) die("enter username");
        if (empty($password)) die("enter password");

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->execute([':username' => $username, ':password' => $password]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $_SESSION['userID'] = $row['id'];
        $_SESSION['accessLevel'] = $row['accessLevel'];
        $_SESSION['uname'] = $username;

        return $row;
    }

    public function Logout(): void {
        $_SESSION = [];
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
    }

    public function CSVchars(string $str): string {
        return preg_replace(["/\"/", "/'/", "/\r\n|\r|\n|\t/"], ' ', $str);
    }

    public function writeCSV(array $rows, string $listtype): void {
        if (!$rows) die("bad result parameter");

        $filename = "apexartList" . date("___m-d-y__h_i_s_A") . ".csv";
        $f2 = fopen($filename, "w");

        if (!$f2) die("couldn't open file " . $filename);

        foreach ($rows as $row) {
            if ($listtype === "dontcare" || (isset($row[$listtype]) && $row[$listtype] == 1)) {
                $fields = [
                    'firstname', 'lastname', 'title', 'company',
                    'address', 'city', 'state', 'zip', 'country',
                    'phone', 'fax', 'email', 'comments',
                    'juror', 'juror_past'
                ];
                foreach ($fields as $field) {
                    $val = $row[$field] ?? '';
                    fwrite($f2, '"' . $this->CSVchars($val) . '",');
                }
                fwrite($f2, "
");
            }
        }

        fclose($f2);
        header("Location: $filename");
        exit();
    }

    public function SearchSort(string $expression, string $type, int $start, bool $needCSV, string $listtype, ?string $sortOrder, bool $exactMatch, string $expression2 = '', string $type2 = '', bool $exactMatch2 = false): array {
    $query = "SELECT *, UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(lastUpdated) as SpanUpdate FROM people WHERE personDeleted = 0";
    $params = [];

    if (!empty($type)) {
        if ($exactMatch) {
            $query .= " AND $type = :expression";
            $params[':expression'] = $expression;
        } else {
            $query .= " AND $type LIKE :expression";
            $params[':expression'] = "%$expression%";
        }
    }

    if (!empty($type2) && !empty($expression2)) {
        if ($exactMatch2) {
            $query .= " AND $type2 = :expression2";
            $params[':expression2'] = $expression2;
        } else {
            $query .= " AND $type2 LIKE :expression2";
            $params[':expression2'] = "%$expression2%";
        }
    }

    if (!empty($sortOrder)) {
        $query .= " ORDER BY $sortOrder";
    }

    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION["numrows"] = count($rows);

    if ($needCSV) $this->writeCSV($rows, $listtype);

    return $rows;
}

    public function LoadSubmissionLIST(int $start): array {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM people");
        $this->subNum = (int) $stmt->fetchColumn();
        $this->pagesCount = $this->subNum / $this->pageSize;
        $offset = $start * $this->pageSize;

        $stmt = $this->conn->prepare("SELECT * FROM people LIMIT :start, :pageSize");
        $stmt->bindValue(':start', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':pageSize', $this->pageSize, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function LoadSubmission(int $subID): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM people WHERE id = :id");
        $stmt->execute([':id' => $subID]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function deletePerson(int $id): void {
        $stmt = $this->conn->prepare("UPDATE people SET `personDeleted` = 1 WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
    public function getPersonByID($id) {
    $stmt = $this->conn->prepare("SELECT * FROM people WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
    public function SearchDonations(string $date1, string $date2, float $amount1, float $amount2, string $comment = ''): array {
        $query = "SELECT *, UNIX_TIMESTAMP(d.date) as unixDate, ammount as damount
                  FROM donations d
                  JOIN people p ON d.donorID = p.ID
                  WHERE d.date BETWEEN :date1 AND :date2
                  AND ammount BETWEEN :amount1 AND :amount2";
        if (!empty($comment)) {
            $query .= " AND paymentMethod LIKE :comment";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':date1', $date1);
        $stmt->bindValue(':date2', $date2);
        $stmt->bindValue(':amount1', $amount1);
        $stmt->bindValue(':amount2', $amount2);
        if (!empty($comment)) {
            $stmt->bindValue(':comment', "%$comment%");
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function LoadDonationLIST(int $id): array {
        $stmt = $this->conn->prepare("SELECT *, UNIX_TIMESTAMP(date) as unixDate FROM donations WHERE donorID = :id ORDER BY position");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createDonation(array $row): void {

        $stmt = $this->conn->prepare("INSERT INTO donations (date, ammount, paymentMethod, donorID, position, oldAmount) VALUES (:date, :ammount, :paymentMethod, :donorID, :position, :oldAmount)");
        $stmt->execute([
            ':date' => $row['date'] ?? '',
            ':ammount' => $row['ammount'] ?? 0,
            ':paymentMethod' => $row['paymentMethod'] ?? '',
            ':donorID' => $row['donorID'] ?? 0,
            ':position' => $row['position'] ?? 10,
            ':oldAmount' => $row['oldAmount'] ?? 0
        ]);

        $stmt = $this->conn->prepare("UPDATE people SET hasDonated = 1 WHERE id = :id");
        $stmt->execute([':id' => $row['donorID']]);
    }

    public function UpdateSubmission(array $row): void {
    $fields = [
        'firstname', 'lastname', 'company', 'address', 'city', 'state', 'zip',
        'country', 'phone', 'fax', 'email', 'comments', 'creditLine', 'title', 'alt'
    ];

    $sql = "UPDATE people SET ";
    $params = [];

    foreach ($fields as $field) {
        $sql .= "`$field` = :$field, ";
        $params[":$field"] = $row[$field] ?? '';
    }

    foreach ($this->statCols as $column) {
        $sql .= "`$column` = :$column, ";
        $params[":$column"] = $row[$column] ?? 0;
    }

    $sql = rtrim($sql, ", ") . " WHERE `id` = :id";
    $params[":id"] = $row['id'];

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
}
    
    public function createSubmission(array $row): bool {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM people WHERE firstname = :firstname AND lastname = :lastname");
        $stmt->execute([
            ':firstname' => trim($row['firstname']),
            ':lastname' => trim($row['lastname'])
        ]);

        if ($stmt->fetchColumn() > 0 && empty($row['updateANYWAY'])) {
            return false;
        }

        $fields = ['firstname', 'lastname', 'company', 'address', 'city', 'state', 'zip', 'country', 'phone', 'fax', 'email', 'comments', 'creditLine', 'title', 'alt'];
        $values = [];
        $params = [];

        foreach ($fields as $field) {
            $values[] = ":$field";
            $params[":$field"] = $row[$field] ?? '';
        }

        foreach ($this->statCols as $column) {
            $values[] = ":$column";
            $params[":$column"] = $row[$column] ?? 0;
        }

        $columns = array_merge($fields, array_values($this->statCols));
        $escaped_columns = array_map(fn($col) => "`$col`", $columns);
        $sql = "INSERT INTO people (" . implode(", ", $escaped_columns) . ") VALUES (" . implode(", ", $values) . ")";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return true;
    }
}
