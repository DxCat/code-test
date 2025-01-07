import React, { useState } from "react";
import axios from "axios";
import { Box, Button, Input, Typography, Card, CircularProgress } from "@mui/joy";

const SQLImprovement = () => {
  const [search, setSearch] = useState("welder");
  const [originalResult, setOriginalResult] = useState(null);
  const [newResult, setNewResult] = useState(null);
  const [originalTime, setOriginalTime] = useState(null);
  const [newTime, setNewTime] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

  const handleFetch = async () => {
    setError("");
    setOriginalResult(null);
    setNewResult(null);
    setOriginalTime(null);
    setNewTime(null);
    setLoading(true);

    try {
      const [originalResponse, newResponse] = await Promise.all([
        axios.get("/api/original-query", { params: { search } }),
        axios.get("/api/new-query", { params: { search } }),
      ]);

      setOriginalResult(originalResponse.data.results);
      setOriginalTime(originalResponse.data.execution_time.toFixed(2));

      setNewResult(newResponse.data.results);
      setNewTime(newResponse.data.execution_time.toFixed(2));
    } catch (err) {
      setError(err.response?.data?.message || "An error occurred");
    } finally {
      setLoading(false);
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
        padding: "30px 0",
      }}
    >
      <Typography level="h4" textAlign="center">
        SQL Query Comparison
      </Typography>

      <Input
        type="text"
        value={search}
        onChange={(e) => setSearch(e.target.value)}
        placeholder="Enter search term - Optional, can be empty"
        sx={{
          width: "100%",
        }}
      />

      <Button
        onClick={handleFetch}
        variant="solid"
        sx={{
          width: "100%",
        }}
        disabled={loading}
      >
        {loading ? "Loading..." : "Compare Queries"}
      </Button>

      {error && (
        <Typography color="danger" textAlign="center">
          {error}
        </Typography>
      )}

      <Card
        variant="outlined"
        sx={{
          padding: 2,
          width: "100%",
          marginTop: 2,
          display: "flex",
          flexDirection: "column",
        }}
      >
        <Typography level="h5" marginBottom={2}>
          Original Query Result
        </Typography>
        {loading ? (
          <Box sx={{ display: "flex", justifyContent: "center" }}>
            <CircularProgress size="lg" />
          </Box>
        ) : (
          <>
            {originalTime && (
              <Typography level="body2" marginBottom={1}>
                Time Taken: {originalTime} ms
              </Typography>
            )}
            {originalResult && (
              <Typography level="body2" marginBottom={1}>
                Rows Fetched: {Array.isArray(originalResult) ? originalResult.length : 0}
              </Typography>
            )}
            <Box
              sx={{
                maxHeight: "400px",
                overflow: "auto",
                backgroundColor: "#f4f4f4",
                padding: 2,
                borderRadius: 1,
                fontFamily: "monospace",
              }}
            >
              {originalResult ? (
                <pre style={{ margin: 0 }}>
                  {JSON.stringify(originalResult, null, 2)}
                </pre>
              ) : (
                <Typography textAlign="center">No data</Typography>
              )}
            </Box>
          </>
        )}
      </Card>

      <Card
        variant="outlined"
        sx={{
          padding: 2,
          width: "100%",
          marginTop: 2,
          display: "flex",
          flexDirection: "column",
        }}
      >
        <Typography level="h5" marginBottom={2}>
          New Query Result
        </Typography>
        {loading ? (
          <Box sx={{ display: "flex", justifyContent: "center" }}>
            <CircularProgress size="lg" />
          </Box>
        ) : (
          <>
            {newTime && (
              <Typography level="body2" marginBottom={1}>
                Time Taken: {newTime} ms
              </Typography>
            )}
            {newResult && (
              <Typography level="body2" marginBottom={1}>
                Rows Fetched: {Array.isArray(newResult) ? newResult.length : 0}
              </Typography>
            )}
            <Box
              sx={{
                maxHeight: "400px",
                overflow: "auto",
                backgroundColor: "#f4f4f4",
                padding: 2,
                borderRadius: 1,
                fontFamily: "monospace",
              }}
            >
              {newResult ? (
                <pre style={{ margin: 0 }}>
                  {JSON.stringify(newResult, null, 2)}
                </pre>
              ) : (
                <Typography textAlign="center">No data</Typography>
              )}
            </Box>
          </>
        )}
      </Card>
    </Box>
  );
};

export default SQLImprovement;
