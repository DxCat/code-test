import React, { useState } from "react";
import axios from "axios";
import { Box, Button, Input, Typography, Card, Grid } from "@mui/joy";

const CardDistributor = () => {
  const [people, setPeople] = useState("");
  const [result, setResult] = useState(null);
  const [error, setError] = useState("");

  const handleDistribute = async () => {
    setError("");
    setResult(null);

    try {
      const response = await axios.post("/api/distribute", {
        people_count: Number(people),
      });
      setResult(response.data);
    } catch (err) {
      setError(err.response?.data?.message || "Irregularity occurred");
    }
  };

  return (
    <Box
      sx={{
        width: "100%",
        maxWidth: "900px",
        margin: "auto",
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        gap: 2,
        padding: "30px 0"
      }}
    >
      <Typography level="h4" textAlign="center">
        Card Distributor
      </Typography>

      <Input
        type="number"
        value={people}
        onChange={(e) => setPeople(e.target.value)}
        placeholder="Enter number of people"
        sx={{ width: "400px" }}
      />

      <Button onClick={handleDistribute} variant="solid" sx={{ width: "400px" }}>
        Distribute Cards
      </Button>

      {error && (
        <Typography color="danger" textAlign="center">
          {error}
        </Typography>
      )}

      {result && (
        <Grid container spacing={2} sx={{ marginTop: 2 }}>
          {result.map((cards, index) => (
            <Grid xs={12} key={index}>
              <Card variant="outlined" sx={{ padding: 2 }}>
                <Typography level="h6">
                  Person {index + 1}:
                </Typography>
                <Typography>
                  {cards.length === 0 ? "No cards" : cards.join(", ")}
                </Typography>
              </Card>
            </Grid>
          ))}
        </Grid>
      )}
    </Box>
  );
};

export default CardDistributor;
