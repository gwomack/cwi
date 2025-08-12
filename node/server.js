import express from 'express'
import dotenv from 'dotenv'

dotenv.config()
const app = express()
const PORT = process.env.PORT || 3000

const checkToken = function (req, res, next) {
  const token = req.headers.authorization || ''
  const bearerToken = token.split(' ')[1] || ''

  console.log(bearerToken)

  if (bearerToken !== process.env.TOKEN) {
    return res.status(401).json({ message: 'Token not found' })
  }

  next()
}

app.use(checkToken)

app.get('/health', (req, res) => {
  res.json({ status: 'ok' })
})

app.listen(PORT)