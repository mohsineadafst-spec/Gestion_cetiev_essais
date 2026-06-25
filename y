{
  "authHost": "http://localhost",
  "authEndpoint": "/broadcasting/auth",
  "clients": [
    {
      "appId": "d15487e04d3072b5",
      "key": "fa4be32f0b6b20e58835d29ab92888ce"
    }
  ],
  "database": "sqlite",
  "databaseConfig": {
    "redis": {},
    "sqlite": {
      "databasePath": "database/laravel-echo-server.sqlite"
    }
  },
  "devMode": true,
  "host": null,
  "port": 6001,
  "protocol": "http",
  "socketio": {},
  "secureOptions": 67108864,
  "sslCertPath": "",
  "sslKeyPath": "",
  "sslCertChainPath": "",
  "sslPassphrase": "",
  "subscribers": {
    "http": true,
    "redis": true
  },
  "apiOriginAllow": {
    "allowCors": true,
    "allowOrigin": "http://localhost:5173",
    "allowMethods": "GET, POST",
    "allowHeaders": "Origin, Content-Type, X-Auth-Token"
  }
}
