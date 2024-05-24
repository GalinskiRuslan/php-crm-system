<form method="POST" action="/verify">
    @csrf
    <input type="text" name="phone" placeholder="Phone">
    <input type="text" name="verification_code" placeholder="Verification Code">
    <button type="submit">Verify</button>
</form>
