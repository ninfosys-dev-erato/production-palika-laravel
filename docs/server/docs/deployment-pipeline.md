# Deployment Pipeline for Digital Epalika

To deploy to any `acme` palika do the following things.

1. Login to the server using SSH:
```
ssh epalikadmin@<server-ip>
```
2. Navigate to the Digital Epalika directory:
```cd /home/epalikadmin/digital-epalika/code```

3. Clone the git repository of `production-palika`:
```
git clone https://git.ninjainfosys.com.np/palika-software/production-palika <acme-palika>
```
Example:
```git clone https://git.ninjainfosys.com.np/palika-software/production-palika ghoraimun```

Enter git credentials if prompted.

4. Checkout to the `dev` branch.
```cd ghoraimun
git checkout dev
```

5. Create a `.env` file by copying the example:
```bash
cp .env.example .env
```

6. 


