import json
import hashlib

# Your JSON data as a dictionary
json_data = {
    "data": {
        "id": 1,
        "user_id": None,
        "user_type": None,
        "event": "updated",
        "auditable_id": "f4599db6-4960-11ee-a18e-327acb8e6551",
        "auditable_type": "App\\Models\\Team",
        "old_values": {
                    "team_name": "Alpha-1",
                    "updated_at": "2023-09-03 08:04:49"
                },
                "new_values": {
                    "team_name": "Alpha 0000",
                    "updated_at": "2023-09-07 13:37:42"
                },
        "ip_address": "127.0.0.1",
                "url": "http:\/\/127.0.0.1:8000\/api\/profile",
                "user_agent": "apitester.org Android\/7.4(635)",
                "tags": None,
                "created_at": "2023-09-07 13:37:43",
    },
    "previous": "6c1be274af792f830ccdbcb303ac621feac595fbdf640fb309cc01b29eae5834",
    "nonce": "36153"
}

# Convert the dictionary to a JSON-formatted string
json_string = json.dumps(json_data)

# Calculate the SHA-256 hash of the JSON string
sha256_hash = hashlib.sha256(json_string.encode()).hexdigest()

# Output the SHA-256 hash
print(sha256_hash)
