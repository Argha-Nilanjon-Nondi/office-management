
# Project Title

A brief description of what this project does and who it's for


## API Reference

#### Login a user


To log in to the API endpoint using cURL, you can use the following command:

##### Request
```bash
curl -X POST 'http://127.0.0.1:8000/api/login' \
     -H 'Content-Type: application/json' \
     -H 'Accept: application/json' \
     -d '{
             "email": "<email>",
             "password": "<password>"
         }'
```

##### Response
###### content
```json
{
  "token": "387f400663e8e171ced8cf8fc096e9410f8f95ed7c1201b90848817ae0cf19bb"
}
```
